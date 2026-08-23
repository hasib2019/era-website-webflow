import puppeteer from 'puppeteer-core';
const CHROME = process.env.CHROME_PATH ?? 'C:/Program Files/Google/Chrome/Application/chrome.exe';
const targets = [['converted','http://127.0.0.1:8126/'],['export   ','file:///D:/ERA/Era-WEBSITE-Templete/era-website/index.html']];
const PROBES = [
  ['.section-home-about-us .caption', 'ABOUT US caption'],
  ['.home-about-us-content .text-animation-block', 'about heading'],
  ['.service-collection-list-wrapper', 'services list'],
  ['.case-study-collection-item', 'case study card'],
  ['.our-process-list', 'process list'],
  ['.video-lightbox', 'video zoom'],
  ['.footer-menu-list', 'footer menu'],
];
const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new', args: ['--disable-gpu','--no-sandbox','--allow-file-access-from-files'] });

for (const [label, url] of targets) {
  const page = await browser.newPage();
  await page.setViewport({ width: 1366, height: 900 });
  await page.goto(url, { waitUntil: 'networkidle2', timeout: 45000 }).catch(()=>{});
  await new Promise(r => setTimeout(r, 1200));

  // walk down the page so scroll-into-view triggers actually fire
  const height = await page.evaluate(() => document.body.scrollHeight);
  for (let y = 0; y < height; y += 400) {
    await page.evaluate((y) => window.scrollTo(0, y), y);
    await new Promise(r => setTimeout(r, 120));
  }
  await new Promise(r => setTimeout(r, 1500));

  const out = await page.evaluate((probes) => probes.map(([sel, name]) => {
    const el = document.querySelector(sel);
    if (!el) return `${name}: MISSING`;
    const cs = getComputedStyle(el);
    const t = cs.transform === 'none' ? 'none'
      : cs.transform.replace(/matrix\(|\)/g,'').split(',').map(n=>Math.round(parseFloat(n)*100)/100).join(',');
    return `${name.padEnd(18)} opacity=${(+cs.opacity).toFixed(2)}  tf=${t}`;
  }), PROBES);

  console.log('\n=== ' + label + ' (after walking the whole page) ===');
  out.forEach(r => console.log('  ' + r));
  await page.close();
}
await browser.close();
