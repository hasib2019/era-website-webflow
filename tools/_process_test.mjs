import puppeteer from 'puppeteer-core';

const BASE = (process.env.BASE_URL ?? 'http://127.0.0.1:8000').replace(/\/$/, '');
const CHROME = process.env.CHROME_PATH ?? 'C:/Program Files/Google/Chrome/Application/chrome.exe';

const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new', args: ['--disable-gpu', '--no-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1400, height: 1000 });

await page.goto(BASE + '/admin/login', { waitUntil: 'networkidle2' });
await page.type('input[name="email"]', 'admin@erainfotechbd.com');
await page.type('input[name="password"]', 'Era@2026!');
await Promise.all([page.waitForNavigation({ waitUntil: 'networkidle2' }), page.click('button[type="submit"]')]);

// nav link present?
await page.goto(BASE + '/admin/pages', { waitUntil: 'networkidle2' });
const navHasLink = await page.evaluate(() => document.body.textContent.includes('Process steps'));
console.log('nav shows "Process steps":', navHasLink);

// the index screen itself
const res = await page.goto(BASE + '/admin/process-steps', { waitUntil: 'networkidle2' });
console.log('GET /admin/process-steps status:', res.status());
const rows = await page.evaluate(() =>
    [...document.querySelectorAll('tbody tr')].map((tr) => [...tr.querySelectorAll('td')].map((td) => td.textContent.trim()).slice(0, 4))
);
console.log('rows:', JSON.stringify(rows, null, 2));

// the section shortcut on /admin/pages/home
await page.goto(BASE + '/admin/pages/home', { waitUntil: 'networkidle2' });
const shortcut = await page.evaluate(() => {
    const links = [...document.querySelectorAll('a')].filter((a) => a.textContent.includes('Edit the process steps'));
    return links.map((a) => a.getAttribute('href'));
});
console.log('shortcut link(s) on /admin/pages/home:', shortcut);

// edit one step and save, then confirm it reflects on the live homepage
const editRes = await page.goto(BASE + '/admin/process-steps', { waitUntil: 'networkidle2' });
const firstEditHref = await page.evaluate(() => document.querySelector('tbody tr a[href*="/edit"]')?.getAttribute('href'));
console.log('first edit link:', firstEditHref);
if (firstEditHref) {
    await page.goto(BASE + firstEditHref, { waitUntil: 'networkidle2' });
    const titleInput = await page.$('input[name="title"]');
    const before = await page.evaluate((el) => el.value, titleInput);
    console.log('title before:', before);
    await titleInput.click({ clickCount: 3 });
    await titleInput.type('Analyze (edited)');
    await Promise.all([
        page.waitForNavigation({ waitUntil: 'networkidle2' }),
        page.click('button[type="submit"]'),
    ]);
    console.log('after save, url:', page.url());

    // restore it back so we don't leave test content on the site
    await page.goto(BASE + firstEditHref, { waitUntil: 'networkidle2' });
    const titleInput2 = await page.$('input[name="title"]');
    await titleInput2.click({ clickCount: 3 });
    await titleInput2.type(before);
    await Promise.all([
        page.waitForNavigation({ waitUntil: 'networkidle2' }),
        page.click('button[type="submit"]'),
    ]);
    console.log('restored to original title:', before);
}

await browser.close();
