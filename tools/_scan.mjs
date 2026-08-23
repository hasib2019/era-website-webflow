import puppeteer from 'puppeteer-core';
const CHROME = process.env.CHROME_PATH ?? 'C:/Program Files/Google/Chrome/Application/chrome.exe';
const targets = [['converted','http://127.0.0.1:8126/'],['export   ','file:///D:/ERA/Era-WEBSITE-Templete/era-website/index.html']];
const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new', args: ['--disable-gpu','--no-sandbox','--allow-file-access-from-files'] });

for (const [label, url] of targets) {
  const page = await browser.newPage();
  await page.setViewport({ width: 1366, height: 900 });
  await page.goto(url, { waitUntil: 'networkidle2', timeout: 45000 }).catch(()=>{});
  await new Promise(r => setTimeout(r, 1200));

  const h = await page.evaluate(() => document.body.scrollHeight);
  const sectionTop = await page.evaluate(() => {
    const s = document.querySelector('.section-home-video');
    return s ? Math.round(s.getBoundingClientRect().top + window.scrollY) : -1;
  });
  console.log(`\n=== ${label}  pageHeight=${h}  videoSectionTop=${sectionTop} ===`);

  const samples = [];
  for (let y = 0; y <= h; y += 300) {
    await page.evaluate((y) => window.scrollTo(0, y), y);
    await new Promise(r => setTimeout(r, 90));
    const s = await page.evaluate(() => {
      const v = document.querySelector('.video-lightbox');
      const p = document.querySelector('.our-process-list');
      const f = (el) => { if (!el) return 'x'; const t = getComputedStyle(el).transform;
        return t === 'none' ? 'none' : t.replace(/matrix\(|\)/g,'').split(',').map(n=>Math.round(parseFloat(n)*10)/10).join(','); };
      return { v: f(v), p: f(p), po: p ? (+getComputedStyle(p).opacity).toFixed(1) : 'x' };
    });
    samples.push(`${String(y).padStart(5)}  video=${s.v.padEnd(28)} process=${s.p.padEnd(18)} op=${s.po}`);
  }
  // only print rows where something changed
  let last = '';
  for (const row of samples) {
    const key = row.slice(7);
    if (key !== last) { console.log('  ' + row); last = key; }
  }
  await page.close();
}
await browser.close();
