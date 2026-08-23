# 07 — Responsive

## Where responsive CSS lives

`public/site/css/styles.css` is the Webflow export and is kept **byte-identical**
so a fresh export stays a drop-in replacement. Every correction to the template's
own responsive gaps goes in:

```
public/site/css/responsive-fixes.css
```

loaded straight after it from `resources/views/site/partials/head.blade.php`.
Each block in that file states what breaks without it and at which widths, so
rules can be dropped one at a time if a future export fixes the same thing.

**Do not edit `styles.css`.** A change there is invisible to `verify.php` (which
compares markup, not CSS) and will be lost the next time the design is
re-exported.

## Measuring, not eyeballing

```bash
php artisan serve
node tools/responsive-audit.mjs                       # every page, 12 widths
node tools/responsive-audit.mjs / /about              # just these
WIDTHS="320,360,390,414" node tools/responsive-audit.mjs /
BASE_URL=http://127.0.0.1:8080 node tools/responsive-audit.mjs
```

For each page and width it loads the real page in Chrome and reports every
element that either

- **leaves the viewport** — its box crosses the left or right edge, or
- **clips its own text** — `scrollWidth` exceeds `clientWidth` on a text node.

It must end with `16/16 pages clean`.

Blocks the template deliberately paints outside their box — the button hover
roll, the service row images that slide in, the client marquee, the counter
reels, the custom cursor — are listed in `BY_DESIGN` at the top of the script.
**Be sparing with that list.** Two real bugs hid behind it during the first
responsive pass: the lightbox thumbnail and the two heading wrappers.

## Looking at a page

```bash
node tools/screenshot.mjs /                    # 390, 768, 1366
node tools/screenshot.mjs /about about 320,480
FULL_PAGE=1 node tools/screenshot.mjs /
```

> **The trap that cost an afternoon.** `chrome --headless --window-size=390,1200
> --screenshot` does **not** emulate a mobile viewport. `width=device-width`
> still resolves to a desktop width, so the page lays out for desktop and is then
> *cropped* to 390px. The result looks exactly like broken responsive CSS —
> headlines running off the right edge — when nothing is wrong.
>
> `tools/screenshot.mjs` sets a real viewport with `isMobile`, which is the only
> way to see what a phone renders. Trust it over the CLI flag.

## What was corrected, and why

| # | Symptom | Cause |
|---|---|---|
| 1 | long words cut off mid-word | display faces are set in fixed pixel steps, so one long word can exceed its column; `overflow-wrap: break-word` makes it wrap instead of vanish |
| 2 | `/about` heading lost the tail of "expressions" at 480px | `.display-large` steps 84 → 60 → 34px, so it sits at 60px across the whole 480–767 band; now scales with the viewport in between |
| 3 | case study titles cut off at ~1024px | `.case-study-title` only drops below 991px, so 992–1100 kept the full size in an already-narrow column |
| 4 | risk of a sideways scrollbar | off-canvas animation start states are now clipped with `overflow-x: clip`, which — unlike `hidden` — does not create a scroll container |
| 5 | images wider than their column | `max-width: 100%` on media |
| 6 | half-cut video thumbnail over the copy below 414px | Webflow parks it at `scale(.3) translate(-160px, …)` and grows it on scroll; a small nudge on desktop, half the screen on a phone. Below 480px the zoom is skipped |

## The footer bug this pass uncovered

The reported symptom — text running off the landing page — was **not** a CSS
problem. `tools/wire_footer.php` closed one `</div>` where two were needed, which
left `footer-bottom-element` parented inside `.footer-top-element`. That grid is
`1.25fr 1fr`; a third child made the tracks resolve to `1080px 273px` in a
1200px container, pushing the COMPANY and UTILITY columns hundreds of pixels off
screen at every laptop width. The footer is on every page, the landing page
included.

`verify.php` did not catch it because `skeleton()` compared a flat, ordered list
of elements — and reparenting changes neither the set nor the document order.
**It now records each element's depth below `<body>`**, so a block that moves to a
different parent shows up as drift.

If you write a pass that splices markup, close what you opened: prefer
`substr($html, $end)` over appending a hand-counted `</div>`.

## Adding a responsive fix

1. Reproduce it: `node tools/responsive-audit.mjs <path>` and, if it needs eyes,
   `node tools/screenshot.mjs <path> name <width>`.
2. Find the rule behind it in `styles.css` — the ladder of breakpoints for that
   class usually shows the gap.
3. Add a block to `responsive-fixes.css` with a comment saying what breaks
   without it and at which widths.
4. Re-run the audit; it must reach `16/16 pages clean`.
5. Run `php tools/verify.php` too — CSS should not change the markup, and if it
   reports drift you changed something you did not mean to.
