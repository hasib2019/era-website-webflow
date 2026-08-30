# ERA Infotech — Laravel CMS

The `era-website` Webflow export rebuilt on Laravel 12 with a Blade admin dashboard.
Every public page is byte-for-byte equivalent to the original export; the copy,
images and repeating cards now come from the database.

## Documentation

`docs/README.md` is the index. Two rules matter before you touch anything:

1. **`resources/views/site/**` is generated** by `php tools/build.php`. Never
   hand-edit it — change the export or a wiring pass, then rebuild.
2. **Run `php tools/build.php --verify` after any site change.** It must print
   `all pages structurally identical`.

Agents: load the `era-cms` skill (`.claude/skills/era-cms/`).

## Requirements

| Component | Version used |
|---|---|
| PHP | 8.2 (XAMPP at `D:\XAMPP-8`) — `zip`, `gd`, `intl` enabled |
| Laravel | 12.x (13 needs PHP 8.3+) |
| MySQL | XAMPP, database `era_website` |
| Node | 24 (Vite + Tailwind 4, dashboard assets only) |

## Setup

```bash
composer install
npm install && npm run build
php artisan migrate --seed
php artisan serve
```

`php artisan migrate:fresh --seed` rebuilds everything, including the media
library rows for the assets under `public/era/media/webflow`.

Uploads go to `public/era/` and are served as `/era/...`, so there is no
`storage:link` step.

## Sign in

`/admin` — seeded accounts, one per role. Password for all of them comes from
`SEED_ADMIN_PASSWORD` in `.env`, defaulting to `Era@2026!`. **Change these before
the site goes anywhere public.**

| Email | Role | Can do |
|---|---|---|
| superadmin@erainfotechbd.com | Super Admin | everything, including roles and users |
| admin@erainfotechbd.com | Administrator | all content, media, settings, submissions |
| editor@erainfotechbd.com | Editor | pages and collections, no settings |
| author@erainfotechbd.com | Author | blog posts and media uploads only |

Roles are permission sets (25 permissions across 8 groups) and are editable at
`/admin/roles`. The dashboard hides what a role cannot reach, the routes enforce
it again server-side, and `activity_logs` records who changed what.

Two guards protect the install: nobody can deactivate or delete their own
account, and the last active super admin cannot lose that role.

## How the public site gets its content

Three layers, in order of how often they change:

1. **Settings** (`/admin/settings`) — logos, favicon, contact details, social
   links, footer copy. Read with `setting('group.key', 'fallback')`.
2. **Page sections** (`/admin/pages`) — every page is a list of bands, and each
   band holds named fields. Read with `cms('page.section.field', 'fallback')`
   and `cms_image(...)`. 16 pages, 83 sections, 363 fields.
3. **Collections** (`/admin/services`, `/admin/posts`, …) — services, case
   studies, posts, jobs, testimonials, team, clients, FAQs, process steps,
   stats and changelog. Every repeating block on the public pages loops over
   these, including the client marquee and the animated counters.

The four detail pages resolve the record named in the URL and 404 on an
unknown slug, so `/services/paid-advertising` and
`/services/content-marketing` show their own titles, images and copy.

The contact and newsletter forms post to Laravel and land in
`contact_messages` and `subscribers`, which the Inbox screens read. Webflow's
runtime only takes a form over when it has no `action`, so giving each one an
action leaves submission to the browser and keeps the template's own success
and error panels doing their job.

Every binding carries the template's original value as its fallback, so clearing
a field in the dashboard restores what the export shipped rather than leaving a
hole.

## Layout of the converted markup

```
resources/views/site/
├── layouts/app.blade.php      the <html> shell
├── partials/
│   ├── head.blade.php         meta, fonts, favicon
│   ├── navbar.blade.php       top bar + mega menu, driven by menus
│   ├── cart.blade.php         Webflow commerce cart (inert — see below)
│   ├── footer.blade.php       driven by settings + the footer menu
│   ├── cursor.blade.php       the custom cursor
│   └── scripts.blade.php      jQuery, Webflow runtime
└── pages/*.blade.php          one per public page
```

Assets live in `public/site/` (css, js, fonts, the four local images) and
`public/era/` (the media library — uploads plus the files pulled off
Webflow's CDN, served directly as `/era/...`).

## Tooling

The conversion is repeatable rather than a one-off edit. From the project root:

```bash
php tools/extract_content.php     # collection content -> database/data/content.json
php tools/build_pages_json.php    # page sections      -> database/data/pages.json
php tools/convert.php             # export HTML        -> Blade views
php tools/make_dynamic.php        # binds page-section fields
php tools/wire_footer.php         # binds footer to settings + menu
php tools/wire_navbar.php         # binds navbar to settings + menus
php tools/wire_collections.php    # turns repeated cards into loops
php tools/wire_repeaters.php      # process strips (first card keeps its extra class)
php tools/wire_clients.php        # the client marquee, both copies of each row
php tools/wire_stats.php          # the animated counters
php tools/wire_testimonials.php   # the tab slider, ids regenerated per item
php tools/wire_details.php        # detail pages read the record in the URL
php tools/wire_forms.php          # points the two forms at Laravel
php tools/verify.php [-v]         # compares every rendered page to the export
```

`verify.php` is the guard rail: it fetches each page from a running server, parses
both it and the original export, and compares the element skeleton, the visible
text and the image list. It must print **"all pages structurally identical"**.
Run it after any change to the site views.

## Decisions worth knowing

- **Pricing and Terms & Conditions were dropped.** Both shipped as empty shells.
  Their links are gone from the menus; nothing else changed.
- **The Webflow commerce cart is kept but inert.** It is a shopping cart from the
  original ecommerce template with no backend behind it. It renders because
  removing it changes the navbar layout. Say the word and it comes out.
- **Frozen export state was cleaned up.** 14 of the 16 pages shipped with the
  newsletter button stuck `disabled`, mid-animation `opacity: 0` transforms, and
  a stale Cloudflare Turnstile token. Those are fixed.
- **A broken link was fixed**: the footer's own `https:// erainfotechbd.com/`
  carried a stray space on all 16 pages. It is now a setting.
- **Placeholder copy is still placeholder copy.** The template's lorem ipsum,
  "Fables"/"EDOLY" branding and demo names are seeded as-is so the pages match
  the export. All of it is editable from the dashboard.

## Not yet bound to the database

Two things still render the template markup and will not change from the
dashboard:

- **Career benefits** — the four cards are hand-placed among their four images
  (item, image, item, image, image, item, image, item), so the block is a layout,
  not a repeat. The copy is in the `benefits` table ready for whenever that
  section gets rebuilt.
- **The Webflow commerce cart** — a shopping cart from the original ecommerce
  template with no backend behind it. It renders because removing it changes the
  navbar layout. Say the word and it comes out.

One deliberate normalisation is worth knowing about: the export nested an extra
class-less `<div>` inside `.testimonial-inside-image-parent` on the first slide
only. Neither element has any CSS, so `drop_stray_testimonial_wrapper()` removes
it from both the export and the views, which lets all five slides share one loop.
