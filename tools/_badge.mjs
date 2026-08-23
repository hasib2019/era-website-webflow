import puppeteer from 'puppeteer-core';
const CHROME = process.env.CHROME_PATH ?? 'C:/Program Files/Google/Chrome/Application/chrome.exe';
const targets = [['converted','http://127.0.0.1:8126/'],['export','file:///D:/ERA/Era-WEBSITE-Templete/era-website/index.html']];
const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new', args: ['--disable-gpu','--no-sandbox','--allow-file-access-from-files'] });
for (const [label, url] of targets) {
  const page = await browser.newPage();
  await page.setViewport({ width: 1366, height: 900 });
  await page.goto(url, { waitUntil: 'networkidle2', timeout: 45000 }).catch(()=>{});
  await new Promise(r => setTimeout(r, 1500));
  console.log('\n' + label, await page.evaluate(() => {
    const img = document.querySelector('.hero-round-text-image');
    if (!img) return 'MISSING';
    const cs = getComputedStyle(img);
    const b = img.getBoundingClientRect();
    return JSON.stringify({
      src: img.getAttribute('src'),
      natural: img.naturalWidth + 'x' + img.naturalHeight,
      rect: Math.round(b.width) + 'x' + Math.round(b.height),
      cssWidth: cs.width, cssHeight: cs.height, maxW: cs.maxWidth, maxH: cs.maxHeight,
      position: cs.position, inset: `${cs.top}/${cs.right}/${cs.bottom}/${cs.left}`,
      parent: (() => { const p = img.parentElement; const pb = p.getBoundingClientRect(); return p.className + ' ' + Math.round(pb.width) + 'x' + Math.round(pb.height); })(),
    }, null, 1);
  }));
  await page.close();
}
await browser.close();
