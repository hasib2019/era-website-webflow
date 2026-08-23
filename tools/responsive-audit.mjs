/**
 * Finds elements that overflow the viewport, per page, per width.
 *
 * The Webflow export sets several display headings and grids at sizes its own
 * breakpoints never bring back down, so the fix has to be driven by measurement
 * rather than by eye.
 *
 * Usage:
 *   node tools/responsive-audit.mjs                     all pages, all widths
 *   node tools/responsive-audit.mjs / /about            just these paths
 *   BASE_URL=http://127.0.0.1:8000 node tools/…         somewhere else
 */

import puppeteer from 'puppeteer-core';

const BASE = (process.env.BASE_URL ?? 'http://127.0.0.1:8000').replace(/\/$/, '');
const CHROME = process.env.CHROME_PATH ?? 'C:/Program Files/Google/Chrome/Application/chrome.exe';

const WIDTHS = (process.env.WIDTHS ?? "320,360,390,414,480,600,768,834,991,1024,1280,1440").split(",").map(Number);

const ALL_PATHS = [
    '/', '/about', '/services', '/services/paid-advertising',
    '/case-studies', '/case-studies/event-planning-and-management',
    '/blog', '/blog/navigating-search-algorithms-for-regional-impact',
    '/career', '/career/brand-expert',
    '/contact', '/faq', '/why-choose-us', '/changelog', '/style-guide', '/404',
];

const paths = process.argv.slice(2).length ? process.argv.slice(2) : ALL_PATHS;

/** Runs in the page: every element whose box crosses the viewport edge. */
function findOverflow(viewportWidth) {
    const offenders = [];

    // Blocks the template deliberately paints outside its own box: the button
    // hover-roll keeps a second icon parked to the side, the service rows slide
    // an image in from off-canvas, and the client strip and marquees scroll.
    const BY_DESIGN = [
        'button-icon-element', 'button-text-wrap', 'button-text-inner',
        'service-image', 'client-logo-list', 'client-logo-item',
        'testimonial-tabs-menu', 'cursor-wrapper', 'cursor',
        'counting-animation', 'couting-column', 'text-overlay',
        'link-text-wrap',
        'nav-main-menu-link-inner', 'link-inner', 'w-slider-mask', 'w-slider',
    ];

    const byDesign = (el) => {
        for (let n = el; n && n !== document.body; n = n.parentElement) {
            const cls = typeof n.className === 'string' ? n.className : '';
            if (BY_DESIGN.some((c) => cls.split(/\s+/).includes(c))) return true;
        }
        return false;
    };

    for (const el of document.querySelectorAll('body *')) {
        const style = getComputedStyle(el);
        if (style.display === 'none' || style.visibility === 'hidden') continue;

        const box = el.getBoundingClientRect();
        if (box.width === 0 || box.height === 0) continue;

        // (a) the element's own box sticks out of the viewport
        const outside = Math.max(
            Math.round(box.right - viewportWidth),
            Math.round(-box.left),
        );

        // (b) the element's content is wider than the element, so it is
        //     painted outside its own box or clipped by an ancestor
        const clipped = el.scrollWidth - el.clientWidth;
        const textish = el.children.length === 0 && (el.textContent ?? '').trim() !== '';

        // a box that leaves the viewport is always worth reporting; content
        // spilling out of its own box only matters where it is the text itself
        const worst = Math.max(outside, textish ? clipped : 0);
        if (worst < 3) continue;
        if (byDesign(el)) continue;

        // report the outermost offender only; children inherit the problem
        if (offenders.some((o) => o.el.contains(el))) continue;

        offenders.push({
            el,
            selector: el.tagName.toLowerCase() + (el.className && typeof el.className === 'string'
                ? '.' + el.className.trim().split(/\s+/).slice(0, 3).join('.')
                : ''),
            over: worst,
            kind: outside >= worst ? 'outside viewport' : 'content clipped',
            width: Math.round(box.width),
            text: (el.textContent ?? '').trim().replace(/\s+/g, ' ').slice(0, 45),
        });
    }

    return offenders
        .sort((a, b) => b.over - a.over)
        .slice(0, 6)
        .map(({ selector, over, width, text, kind }) => ({ selector, over, width, text, kind }));
}

const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--disable-gpu', '--no-sandbox'],
});

let problems = 0;

for (const path of paths) {
    const rows = [];

    for (const width of WIDTHS) {
        const page = await browser.newPage();
        await page.setViewport({ width, height: 900, isMobile: width < 768, hasTouch: width < 768 });

        try {
            await page.goto(BASE + path, { waitUntil: 'networkidle2', timeout: 30000 });
        } catch {
            await page.close();
            rows.push([width, [{ selector: '(page did not load)', over: 0, width: 0, text: '' }]]);
            continue;
        }

        // let Webflow's runtime settle
        await new Promise((r) => setTimeout(r, 400));

        const scrollWidth = await page.evaluate(() => document.documentElement.scrollWidth);
        const offenders = await page.evaluate(findOverflow, width);
        await page.close();

        if (offenders.length || scrollWidth > width + 1) {
            rows.push([width, offenders, scrollWidth]);
        }
    }

    if (! rows.length) {
        console.log(`\x1b[32m OK \x1b[0m ${path}`);
        continue;
    }

    problems++;
    console.log(`\x1b[31m !! \x1b[0m ${path}`);
    for (const [width, offenders, scrollWidth] of rows) {
        console.log(`      ${width}px  (document scrolls to ${scrollWidth}px)`);
        for (const o of offenders) {
            console.log(`        +${String(o.over).padStart(4)}px  ${o.kind.padEnd(16)} ${o.selector.padEnd(44)} ${o.text}`);
        }
    }
}

await browser.close();

console.log(`\n${paths.length - problems}/${paths.length} pages clean at ${WIDTHS.join(', ')}px`);
process.exit(problems ? 1 : 0);
