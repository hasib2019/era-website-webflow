import puppeteer from 'puppeteer-core';

const BASE = (process.env.BASE_URL ?? 'http://127.0.0.1:8000').replace(/\/$/, '');
const CHROME = process.env.CHROME_PATH ?? 'C:/Program Files/Google/Chrome/Application/chrome.exe';

const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new', args: ['--disable-gpu', '--no-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1400, height: 1000 });

const consoleMsgs = [];
page.on('console', (m) => consoleMsgs.push(`[${m.type()}] ${m.text()}`));
page.on('pageerror', (e) => consoleMsgs.push(`[pageerror] ${e.message}`));

// log in
await page.goto(BASE + '/admin/login', { waitUntil: 'networkidle2' });
await page.type('input[name="email"]', 'admin@erainfotechbd.com');
await page.type('input[name="password"]', 'Era@2026!');
await Promise.all([
    page.waitForNavigation({ waitUntil: 'networkidle2' }),
    page.click('button[type="submit"]'),
]);
console.log('logged in, url:', page.url());

await page.goto(BASE + '/admin/pages/home', { waitUntil: 'networkidle2' });
await new Promise((r) => setTimeout(r, 500));

// find the Hero Image field specifically
const fieldInfo = await page.evaluate(() => {
    const labels = [...document.querySelectorAll('[data-media-picker-field]')];
    return labels.map((f) => {
        const label = f.closest('div')?.querySelector('label span')?.textContent?.trim()
            ?? f.parentElement?.previousElementSibling?.textContent?.trim();
        return {
            currentValue: f.querySelector('[data-media-picker-value]')?.value,
            name: f.querySelector('[data-media-picker-value]')?.getAttribute('name'),
        };
    });
});
console.log('media-picker fields on page:', JSON.stringify(fieldInfo, null, 2));

// locate the Hero Image field by its input's name attribute
const heroFieldHandle = await page.evaluateHandle(() => {
    return [...document.querySelectorAll('[data-media-picker-field]')]
        .find((f) => f.querySelector('[data-media-picker-value]')?.getAttribute('name') === 'content[hero_image]');
});

if (!heroFieldHandle || (await heroFieldHandle.evaluate(el => el === null))) {
    console.log('!! could not find the hero_image media-picker field on the page');
} else {
    const beforeValue = await heroFieldHandle.evaluate((f) => f.querySelector('[data-media-picker-value]').value);
    console.log('hero_image value BEFORE:', beforeValue);

    const openBtn = await heroFieldHandle.evaluateHandle((f) => f.querySelector('[data-media-picker-open]'));
    await openBtn.click();
    await new Promise((r) => setTimeout(r, 400));

    const dialogOpen = await page.evaluate(() => document.querySelector('[data-media-picker-dialog]')?.open);
    console.log('dialog open after click:', dialogOpen);

    // pick a different image than the current one: the first grid item whose filename != current
    const picked = await page.evaluate((before) => {
        const items = [...document.querySelectorAll('[data-media-picker-item]')];
        const candidate = items.find((i) => i.dataset.mediaFilename !== before) || items[0];
        if (!candidate) return null;
        candidate.click();
        return candidate.dataset.mediaFilename;
    }, beforeValue);
    console.log('clicked grid item with filename:', picked);

    await new Promise((r) => setTimeout(r, 300));

    const afterValue = await heroFieldHandle.evaluate((f) => f.querySelector('[data-media-picker-value]').value);
    console.log('hero_image value AFTER picking (before save):', afterValue);

    // submit that specific section's form
    const submitted = await heroFieldHandle.evaluate((f) => {
        const form = f.closest('form');
        if (!form) return 'no form ancestor found';
        form.requestSubmit();
        return 'submitted';
    });
    console.log('submit result:', submitted);

    await page.waitForNavigation({ waitUntil: 'networkidle2' }).catch(() => console.log('(no navigation detected)'));
    console.log('url after submit:', page.url());
}

console.log('\nCONSOLE:\n' + (consoleMsgs.join('\n') || '(none)'));

await browser.close();
