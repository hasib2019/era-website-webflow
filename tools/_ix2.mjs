import puppeteer from 'puppeteer-core';
const CHROME = process.env.CHROME_PATH ?? 'C:/Program Files/Google/Chrome/Application/chrome.exe';
const targets = [['converted','http://127.0.0.1:8126/'],['export   ','file:///D:/ERA/Era-WEBSITE-Templete/era-website/index.html']];
const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new', args: ['--disable-gpu','--no-sandbox','--allow-file-access-from-files'] });
for (const [label, url] of targets) {
  const page = await browser.newPage();
  await page.setViewport({ width: 1366, height: 900 });
  await page.goto(url, { waitUntil: 'networkidle2', timeout: 45000 }).catch(()=>{});
  await new Promise(r => setTimeout(r, 1800));
  console.log('\n=== ' + label + ' ===');
  console.log(await page.evaluate(() => {
    const out = [];
    out.push('html data-wf-page=' + document.documentElement.getAttribute('data-wf-page'));
    out.push('html data-wf-site=' + document.documentElement.getAttribute('data-wf-site'));
    let ix2 = null;
    try { ix2 = window.Webflow.require('ix2'); } catch (e) { out.push('ix2 require failed: ' + e.message); }
    if (!ix2) return out.join('\n');
    let st = null;
    try { st = ix2.store.getState(); } catch (e) { out.push('getState failed: ' + e.message); }
    if (st) {
      const d = st.ixData || {};
      out.push('ixData keys: ' + Object.keys(d).join(','));
      out.push('eventTypeMap: ' + Object.keys(d.eventTypeMap || {}).join(','));
      out.push('events: ' + Object.keys(d.events || {}).length);
      out.push('actionLists: ' + Object.keys(d.actionLists || {}).length);
      const ev = Object.values(d.events || {});
      const kinds = {};
      ev.forEach(e => { kinds[e.eventTypeId] = (kinds[e.eventTypeId] || 0) + 1; });
      out.push('event kinds: ' + JSON.stringify(kinds));
      out.push('subscriptions: ' + (st.ixSession?.eventState ? Object.keys(st.ixSession.eventState).length : 'n/a'));
    }
    return out.join('\n');
  }));
  await page.close();
}
await browser.close();
