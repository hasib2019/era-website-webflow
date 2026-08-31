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

await page.goto(BASE + '/admin/process-steps', { waitUntil: 'networkidle2' });
const scopes = await page.evaluate(() => [...document.querySelectorAll('tbody tr td:nth-child(3)')].map((td) => td.textContent.trim()));
console.log('scopes now listed:', [...new Set(scopes)]);
console.log('row count:', scopes.length, '(expect 12: 4 home + 4 service + 4 why-choose-us)');

// direct access to an excluded service-details row should 404
const res9 = await page.goto(BASE + '/admin/process-steps/9/edit', { waitUntil: 'networkidle2' });
console.log('GET /admin/process-steps/9/edit (service-details row) status:', res9.status());

// edit-and-restore round trip on a real row
await page.goto(BASE + '/admin/process-steps', { waitUntil: 'networkidle2' });
const editHref = await page.evaluate(() => {
    const link = [...document.querySelectorAll('tbody tr a')].find((a) => a.textContent.trim() === 'Edit');
    return link?.getAttribute('href');
});
console.log('first edit href (relative):', editHref);

await page.goto(new URL(editHref, BASE).toString(), { waitUntil: 'networkidle2' });
const titleInput = await page.$('input[name="title"]');
const before = await page.evaluate((el) => el.value, titleInput);
await titleInput.click({ clickCount: 3 });
await titleInput.type(before + ' (test)');
await Promise.all([page.waitForNavigation({ waitUntil: 'networkidle2' }), page.click('button[type="submit"]')]);
console.log('saved, redirected to:', page.url());

// confirm it shows on the live homepage
const liveText = await (await fetch(BASE + '/')).text();
console.log('live homepage shows edited title:', liveText.includes(before + ' (test)'));

// restore
await page.goto(new URL(editHref, BASE).toString(), { waitUntil: 'networkidle2' });
const titleInput2 = await page.$('input[name="title"]');
await titleInput2.click({ clickCount: 3 });
await titleInput2.type(before);
await Promise.all([page.waitForNavigation({ waitUntil: 'networkidle2' }), page.click('button[type="submit"]')]);
console.log('restored title to:', before);

await browser.close();
