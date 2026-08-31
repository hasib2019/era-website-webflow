/**
 * Checks that Webflow's interactions still bind after a rebuild.
 *
 * The animations are driven by IX2, which finds its work through `data-w-id` on
 * elements and `data-wf-page` on <html>. A wiring pass that drops, duplicates or
 * reparents one of those leaves the markup looking correct — verify.php passes —
 * while animations quietly stop. Comparing how many event subscriptions IX2
 * actually registers against the same page in the export catches that.
 *
 * Usage:
 *   node tools/interactions-check.mjs
 *   BASE_URL=http://127.0.0.1:8080 node tools/interactions-check.mjs
 */

import puppeteer from 'puppeteer-core';

const BASE = (process.env.BASE_URL ?? 'http://127.0.0.1:8000').replace(/\/$/, '');
const CHROME = process.env.CHROME_PATH ?? 'C:/Program Files/Google/Chrome/Application/chrome.exe';
const EXPORT = (process.env.WEBFLOW_EXPORT_DIR ?? 'D:/ERA/Era-WEBSITE-Templete/era-website')
    .split(String.fromCharCode(92)).join('/')
    .replace(/[/]+$/, '');

/** rendered path => the export page it was built from */
const PAGES = [
    ['/', 'Pages/home.html'],
    ['/about', 'Pages/about.html'],
    ['/services', 'Pages/service.html'],
    ['/services/paid-advertising', 'Pages/services-details.html'],
    ['/case-studies', 'Pages/casestudy.html'],
    ['/blog', 'Pages/blog.html'],
    ['/career', 'Pages/career.html'],
    ['/contact', 'Pages/contact-us.html'],
    ['/faq', 'Pages/faq.html'],
    ['/why-choose-us', 'Pages/why-choose-us.html'],
    ['/changelog', 'Pages/changelog.html'],
    ['/style-guide', 'Pages/style-guide.html'],
];

const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--disable-gpu', '--no-sandbox', '--allow-file-access-from-files'],
});

const probe = async (url) => {
    const page = await browser.newPage();
    await page.setViewport({ width: 1366, height: 900 });

    try {
        await page.goto(url, { waitUntil: 'networkidle2', timeout: 45000 });
    } catch {
        await page.close();
        return null;
    }

    await new Promise((r) => setTimeout(r, 1500));

    const result = await page.evaluate(() => {
        let ix2 = null;
        try {
            ix2 = window.Webflow.require('ix2');
        } catch {
            return { error: 'ix2 unavailable' };
        }

        const state = ix2.store.getState();

        return {
            wfPage: document.documentElement.getAttribute('data-wf-page') ?? '(missing)',
            events: Object.keys(state.ixData?.events ?? {}).length,
            subscriptions: Object.keys(state.ixSession?.eventState ?? {}).length,
            withWid: document.querySelectorAll('[data-w-id]').length,
        };
    });

    await page.close();
    return result;
};

let failures = 0;

for (const [path, exportFile] of PAGES) {
    const mine = await probe(BASE + path);
    const theirs = await probe(`file:///${EXPORT}/${exportFile}`);

    if (! mine || ! theirs || mine.error || theirs.error) {
        console.log(`\x1b[31m !! \x1b[0m ${path.padEnd(30)} could not read interactions`);
        failures++;
        continue;
    }

    const same = mine.subscriptions === theirs.subscriptions
        && mine.wfPage === theirs.wfPage
        && mine.events === theirs.events;

    if (same) {
        console.log(`\x1b[32m OK \x1b[0m ${path.padEnd(30)} ${mine.subscriptions} subscriptions, ${mine.withWid} animated elements`);
        continue;
    }

    failures++;
    console.log(`\x1b[31m !! \x1b[0m ${path.padEnd(30)}`);
    console.log(`        subscriptions  rendered=${mine.subscriptions}  export=${theirs.subscriptions}`);
    console.log(`        events         rendered=${mine.events}  export=${theirs.events}`);
    console.log(`        data-wf-page   rendered=${mine.wfPage}  export=${theirs.wfPage}`);
    console.log(`        [data-w-id]    rendered=${mine.withWid}  export=${theirs.withWid}`);
}

await browser.close();

console.log(`\n${PAGES.length - failures}/${PAGES.length} pages bind the same interactions as the export`);
process.exit(failures ? 1 : 0);
