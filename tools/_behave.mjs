import puppeteer from 'puppeteer-core';
const CHROME = process.env.CHROME_PATH ?? 'C:/Program Files/Google/Chrome/Application/chrome.exe';
const targets = [
  ['converted', 'http://127.0.0.1:8126/'],
  ['export   ', 'file:///D:/ERA/Era-WEBSITE-Templete/era-website/index.html'],
];
const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new',
  args: ['--disable-gpu','--no-sandbox','--allow-file-access-from-files'] });

for (const [label, url] of targets) {
  const page = await browser.newPage();
  const errors = [], failed = [];
  page.on('console', m => { if (m.type() === 'error') errors.push(m.text().slice(0, 110)); });
  page.on('pageerror', e => errors.push('PAGEERROR ' + e.message.slice(0, 110)));
  page.on('requestfailed', r => failed.push(r.url().split('/').pop().slice(0, 50)));
  page.on('response', r => { if (r.status() >= 400) failed.push(r.status() + ' ' + r.url().split('/').pop().slice(0, 45)); });

  await page.setViewport({ width: 1366, height: 900 });
  await page.goto(url, { waitUntil: 'networkidle2', timeout: 45000 }).catch(() => {});
  await new Promise(r => setTimeout(r, 1500));

  const info = await page.evaluate(() => {
    const g = (sel) => {
      const el = document.querySelector(sel);
      if (!el) return sel + ' = MISSING';
      const b = el.getBoundingClientRect();
      const cs = getComputedStyle(el);
      return `${sel}  ${Math.round(b.width)}x${Math.round(b.height)}  opacity=${cs.opacity}  transform=${cs.transform.slice(0, 34)}`;
    };
    return {
      webflow: typeof window.Webflow,
      jquery: typeof window.jQuery,
      ix2: !!(window.Webflow && window.Webflow.require && (() => { try { return window.Webflow.require('ix2'); } catch { return null; } })()),
      modules: window.Webflow && window.Webflow.env ? 'env ok' : 'no env',
      htmlClass: document.documentElement.className.split(/\s+/).filter(c => c.startsWith('w-mod')).join(' '),
      probes: [
        g('.hero-round-text-wrap'),
        g('.hero-round-text-image'),
        g('.round-arrow-icon'),
        g('.title-move-animation'),
        g('.video-lightbox'),
        g('.home-hero-image-wrap img'),
      ],
    };
  });

  console.log('\n=== ' + label + ' ===');
  console.log('  Webflow=' + info.webflow + '  jQuery=' + info.jquery + '  ix2=' + info.ix2 + '  ' + info.modules);
  console.log('  html classes: ' + info.htmlClass);
  info.probes.forEach(p => console.log('  ' + p));
  if (errors.length) console.log('  JS errors: ' + [...new Set(errors)].slice(0, 4).join(' | '));
  if (failed.length) console.log('  failed requests: ' + [...new Set(failed)].slice(0, 6).join(', '));
  await page.close();
}
await browser.close();
