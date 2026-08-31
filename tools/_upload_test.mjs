import puppeteer from 'puppeteer-core';
import path from 'node:path';

const BASE = (process.env.BASE_URL ?? 'http://127.0.0.1:8000').replace(/\/$/, '');
const CHROME = process.env.CHROME_PATH ?? 'C:/Program Files/Google/Chrome/Application/chrome.exe';

const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new', args: ['--disable-gpu', '--no-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1400, height: 1000 });

const consoleMsgs = [];
page.on('console', (m) => { if (m.type() === 'error' || m.type() === 'warning') consoleMsgs.push(`[${m.type()}] ${m.text()}`); });
page.on('pageerror', (e) => consoleMsgs.push(`[pageerror] ${e.message}`));
page.on('response', (r) => { if (r.url().includes('/admin/media') && r.request().method() === 'POST') consoleMsgs.push(`[net] POST ${r.url()} -> ${r.status()}`); });

await page.goto(BASE + '/admin/login', { waitUntil: 'networkidle2' });
await page.type('input[name="email"]', 'admin@erainfotechbd.com');
await page.type('input[name="password"]', 'Era@2026!');
await Promise.all([page.waitForNavigation({ waitUntil: 'networkidle2' }), page.click('button[type="submit"]')]);

await page.goto(BASE + '/admin/pages/home', { waitUntil: 'networkidle2' });
await new Promise((r) => setTimeout(r, 500));

const heroField = await page.evaluateHandle(() =>
    [...document.querySelectorAll('[data-media-picker-field]')]
        .find((f) => f.querySelector('[data-media-picker-value]')?.getAttribute('name') === 'content[hero_image]')
);

const openBtn = await heroField.evaluateHandle((f) => f.querySelector('[data-media-picker-open]'));
await openBtn.click();
await new Promise((r) => setTimeout(r, 400));

const uploadButtonVisible = await page.evaluate(() => !!document.querySelector('[data-media-picker-upload-input]'));
console.log('upload control present in dialog:', uploadButtonVisible);

const fileInput = await page.$('[data-media-picker-upload-input]');
if (!fileInput) {
    console.log('!! no file input found, aborting');
} else {
    await fileInput.uploadFile(path.resolve('tools/_test-upload.png'));
    // change event fires from uploadFile automatically; wait for the network round-trip
    await new Promise((r) => setTimeout(r, 2000));

    const state = await page.evaluate(() => {
        const dialog = document.querySelector('[data-media-picker-dialog]');
        const errorEl = document.querySelector('[data-media-picker-upload-error]');
        return {
            dialogOpen: dialog.open,
            errorVisible: errorEl && !errorEl.classList.contains('hidden'),
            errorText: errorEl?.textContent,
            gridFirstItemFilename: document.querySelector('[data-media-picker-item]')?.dataset.mediaFilename,
        };
    });
    console.log('state after upload:', JSON.stringify(state, null, 2));

    const heroValueAfter = await heroField.evaluate((f) => f.querySelector('[data-media-picker-value]').value);
    console.log('hero_image value after upload+auto-select:', heroValueAfter);

    // did the preview update?
    const previewSrc = await heroField.evaluate((f) => f.querySelector('[data-media-picker-preview]').getAttribute('src'));
    console.log('hero field preview src:', previewSrc);
}

console.log('\nCONSOLE/NETWORK:\n' + (consoleMsgs.join('\n') || '(none)'));

await browser.close();
