/**
 * Screenshots a page at several widths, for eyeballing a design change.
 *
 * Chrome's `--headless --window-size` does NOT emulate a mobile viewport, so a
 * narrow window still lays the page out as desktop and simply crops it — which
 * looks exactly like broken responsive CSS. This sets a real viewport instead,
 * which is the only way to see what a phone actually renders.
 *
 * Usage:
 *   node tools/screenshot.mjs /                       default widths
 *   node tools/screenshot.mjs /about home 390,768
 *   SHOT_DIR=./shots node tools/screenshot.mjs /
 */

import { mkdirSync } from 'node:fs';
import puppeteer from 'puppeteer-core';

const BASE = (process.env.BASE_URL ?? 'http://127.0.0.1:8000').replace(/\/$/, '');
const CHROME = process.env.CHROME_PATH ?? 'C:/Program Files/Google/Chrome/Application/chrome.exe';
const OUT = process.env.SHOT_DIR ?? 'storage/app/screenshots';

const path = process.argv[2] ?? '/';
const name = process.argv[3] ?? (path === '/' ? 'home' : path.replace(/\W+/g, '-').replace(/^-|-$/g, ''));
const widths = (process.argv[4] ?? '390,768,1366').split(',').map(Number);

mkdirSync(OUT, { recursive: true });

const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--disable-gpu', '--no-sandbox'],
});

for (const width of widths) {
    const page = await browser.newPage();
    await page.setViewport({ width, height: 1100, isMobile: width < 768, hasTouch: width < 768 });
    await page.goto(BASE + path, { waitUntil: 'networkidle2', timeout: 40000 });

    // let Webflow's interactions settle before capturing
    await new Promise((r) => setTimeout(r, 900));

    const file = `${OUT}/${name}-${width}.png`;
    await page.screenshot({ path: file, fullPage: process.env.FULL_PAGE === '1' });
    console.log(file);
    await page.close();
}

await browser.close();
