import puppeteer from 'puppeteer-core';
const CHROME = process.env.CHROME_PATH ?? 'C:/Program Files/Google/Chrome/Application/chrome.exe';
const W = Number(process.env.W ?? 1366);
const targets = [
  ['converted', 'http://127.0.0.1:8126/'],
  ['export', 'file:///D:/ERA/Era-WEBSITE-Templete/era-website/index.html'],
];
const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new',
  args: ['--disable-gpu','--no-sandbox','--allow-file-access-from-files'] });

const snap = async (url) => {
  const page = await browser.newPage();
  await page.setViewport({ width: W, height: 900, isMobile: W < 768, hasTouch: W < 768 });
  await page.goto(url, { waitUntil: 'networkidle2', timeout: 45000 }).catch(() => {});
  await new Promise(r => setTimeout(r, 1500));
  const out = await page.evaluate(() => {
    const rows = [];
    let i = 0;
    for (const el of document.querySelectorAll('body *')) {
      if (['script','noscript','style'].includes(el.tagName.toLowerCase())) continue;
      if (el.tagName === 'INPUT' && el.type === 'hidden') continue;
      const b = el.getBoundingClientRect();
      const cls = (typeof el.className === 'string' ? el.className : '').trim().split(/\s+/).slice(0,2).join('.');
      rows.push([`${i++}|${el.tagName.toLowerCase()}.${cls}`, Math.round(b.width) + 'x' + Math.round(b.height)]);
    }
    return rows;
  });
  await page.close();
  return out;
};

const [a, b] = [await snap(targets[0][1]), await snap(targets[1][1])];
console.log(`elements: converted=${a.length} export=${b.length} @${W}px`);

let shown = 0;
const n = Math.min(a.length, b.length);
for (let i = 0; i < n && shown < 25; i++) {
  if (a[i][0] !== b[i][0]) { console.log(`  [${i}] key drift: ${a[i][0]} vs ${b[i][0]}`); shown++; break; }
  if (a[i][1] !== b[i][1]) {
    console.log(`  ${a[i][0].split('|')[1].padEnd(42)} converted=${a[i][1].padEnd(11)} export=${b[i][1]}`);
    shown++;
  }
}
if (!shown) console.log('  no geometry differences');
await browser.close();
