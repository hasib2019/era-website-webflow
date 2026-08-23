# 03 — Build pipeline

## Commands

```bash
php tools/build.php            # rebuild the views from the export
php tools/build.php --data     # re-extract the seed data first, then rebuild
php tools/build.php --verify   # rebuild, then check every page against the export
php tools/verify.php -v        # check only, with per-page detail
```

`--verify` needs the site running (`php artisan serve`). If you serve on a
port other than 8000, point the checker at it:

```bash
VERIFY_BASE_URL=http://127.0.0.1:8080 php tools/verify.php
```

`--data` rewrites
`database/data/*.json`; run `php artisan db:seed` afterwards to load it.

The export's location defaults to `../era-website` and can be moved:

```bash
WEBFLOW_EXPORT_DIR=/path/to/export php tools/build.php
```

## What runs, in order

Order matters. `convert.php` rewrites the views from scratch and every pass after
it edits what the previous one produced.

### Seed data (`--data` only)

| Script | Produces |
|---|---|
| `extract_content.php` | `database/data/content.json` — collection rows read out of the export |
| `build_pages_json.php` | `database/data/pages.json` — page sections, from `tools/inventory/page-inventory.json` |
| `extract_why_choose_us.php` | fills in the one page the inventory pass missed |
| `decode_entities.php` | decodes `&amp;`/`&nbsp;` in plain-text values so Blade re-encodes them correctly |

### Views (always)

| Script | Does |
|---|---|
| `convert.php` | slices each export page into head / navbar / content / footer, writes the Blade views and shared partials |
| `make_dynamic.php` | binds page-section fields — 253 of them |
| `wire_footer.php` | footer → settings + the footer menu |
| `wire_navbar.php` | navbar → settings + the primary and mega menus |
| `wire_collections.php` | repeated cards → collection loops (services, case studies, posts, jobs, FAQs, team) |
| `wire_repeaters.php` | process strips, where the first card carries an extra layout class |
| `wire_clients.php` | the client marquee — both copies of each row |
| `wire_stats.php` | the animated counters |
| `wire_testimonials.php` | the tab slider, regenerating its ids per item |
| `wire_details.php` | detail pages read the record named in the URL |
| `wire_forms.php` | the contact and newsletter forms post to Laravel |

`make_dynamic.php` reports `253 wired, 33 ambiguous, 70 not found` on a clean
build. That is the expected result, not a failure:

- **ambiguous** — the value appears more than three times on the page, so it is
  too generic to bind to one field (a button label like "READ ARTICLE" that
  every card repeats). Those are covered by collection loops instead.
- **not found** — the inventory recorded a value that is not literally in the
  markup: copy that lives in a collection, or an image whose src belongs to a
  different page.

The number that matters is that it stays stable. A sudden jump in *not found*
means a previous pass changed markup that this one was relying on.

### Shared libraries

| File | Holds |
|---|---|
| `config.php` | `EXPORT_ROOT`, `EXPORT_PAGES`, `SITE_VIEWS` |
| `lib_slice.php` | `match_close()` — finds an element's closing tag by counting depth on the raw string |
| `lib_rewrite.php` | every deliberate deviation from the export's bytes |
| `lib_extract.php` | XPath helpers, `media_key()`, `decode_counter()` |

`probe.php` is a diagnostic: it prints the byte size of each slice per page, which
is how you notice a page whose structure differs from the rest.

Two Node tools sit beside the PHP pipeline and need `npm install` first:
`tools/responsive-audit.mjs` measures overflow across widths, and
`tools/screenshot.mjs` captures a page at a real mobile viewport. Both are
covered in [07 — Responsive](07-responsive.md).

## Why string surgery and not a DOM parse

`convert.php` works on raw strings with `match_close()` rather than
`DOMDocument->saveHTML()`. Loading and re-saving reformats attributes, rewrites
self-closing tags and reorders nothing predictably — all of which Webflow's IX2
runtime reads back. The rendered DOM has to be what Webflow expects, so the
markup is copied through byte-for-byte except where a rewrite is intended.

The wiring passes use `preg_replace` against the generated Blade for the same
reason.

## Deliberate deviations from the export

All of these live in `tools/lib_rewrite.php` and are applied to the export **and**
to `verify.php`'s baseline, so they never show up as drift:

| Function | Why |
|---|---|
| `rewrite_assets()` | Webflow CDN URLs → local paths (including percent-encoded copies inside Webflow's own template blobs) |
| `rewrite_links()` | `about.html` → `/about`; the template author's marketplace links → `/contact` |
| `unwrap_dropped_links()` | Pricing and Terms & Conditions shipped as empty shells and were dropped; their anchors are unwrapped so the layout survives |
| `unfreeze()` | removes the frozen `w-form-loading` class, the `disabled` submit button, `data-wf-page-id` and the stale Turnstile token and widget |
| `settle_ix2()` | `translate3d(0, 60px, 0) … opacity: 0` → the settled state, so content is visible if the runtime never boots |
| `drop_stray_testimonial_wrapper()` | the export nested an extra class-less `<div>` inside `.testimonial-inside-image-parent` on slide one only; neither element has any CSS, and removing it lets all five slides share a loop |

Two more fixes are applied by the wiring passes: the filename
`case-study-image-1%20(1).webp` is renamed on disk (a space and parentheses in a
URL), and the footer's own `https:// erainfotechbd.com/` — with a stray space that
made the link dead on all sixteen pages — becomes a setting.

## verify.php

The guard rail. For each of the sixteen pages it:

1. fetches the rendered page from `http://127.0.0.1:8000`, or wherever
   `VERIFY_BASE_URL` points,
2. applies the same deliberate deviations to the original export,
3. parses both and compares three things:
   - the **element skeleton** — every tag plus its classes, in document order,
     ignoring `w--current` and hidden inputs
   - the **visible text** — every text node, whitespace-normalised
   - the **image list** — every `<img src>`, by filename

Output is `source/rendered` counts per page, and it must end with:

```
all pages structurally identical
```

`-v` adds, per failing page, which elements/strings/images are on one side and
not the other. That is almost always enough to find the cause.

### When verify fails

| Symptom | Usual cause |
|---|---|
| the same string repeated N times in the render | a binding regex missed, so the template card's literal repeated |
| N extra/missing bare `<div>`s | a loop swallowed markup that sat *between* cards, or replaced a wrapper's contents |
| `&amp;` on one side | a value carrying markup rendered through `{{ }}` instead of `{!! !!}` |
| a text node differs by whitespace | a non-breaking space retyped as an ordinary one |
| an element with an extra class missing | the first card carried a layout class the template card did not — see `wire_repeaters.php` |

## Adding a wiring pass

The passes all follow one shape:

1. find the run of repeated elements with `preg_match` on a **whole class token**
   — `class="(?:[^"]*\s)?the-class(?:\s[^"]*)?"`, not a substring, or
   `blog-collection-item` will also match `feature-blog-collection-item`;
2. take one card as the template — usually the first, but the **second** when the
   first carries an extra class;
3. check the cards are adjacent (`contiguous()` in `wire_repeaters.php`) so the
   replacement cannot swallow markup between them;
4. rewrite the template's inner values to Blade expressions, matching the tag
   generically (`<(?P<tag>[a-z][a-z0-9]*)`, so `<h3>` works as well as `<div>`)
   and allowing attributes before `class`;
5. replace from the first card's start to the last card's end with one
   `@foreach`;
6. rebuild and verify.

Register the new script in `tools/build.php` so it runs with everything else.
