# 01 — Architecture

## What this project is

`era-website/` holds a Webflow export of the "Edoly" template: 18 HTML files, one
195 KB stylesheet, and Webflow's own JavaScript runtime. `era-website-fullstack/`
is that same site rebuilt on Laravel 12 with an admin dashboard behind it.

The brief was *"hubohu same"* — identical. So the rebuild treats the export as
the specification, not as a starting point. Every page still ships Webflow's
stylesheet and runtime, still carries its `w-*` classes and `data-w-id`
attributes, and still animates the way it did. What changed is where the words
and pictures come from.

## The one rule

> The files in `resources/views/site/pages/` and `resources/views/site/partials/`
> are **generated**. Do not edit them by hand.

`php tools/build.php` rewrites them from the export every time it runs. A hand
edit works right up until someone rebuilds, and then it is gone — with no error
to tell you.

When you need a change, it goes in one of two places:

- **The markup changed** (a new section, a moved element, a different class) →
  change `era-website/Pages/*.html`, then rebuild.
- **What fills the markup changed** (a field should come from the database, a
  card should repeat) → change or add a wiring pass in `tools/`, then rebuild.

[03 — Build pipeline](03-build-pipeline.md) covers both.

## Why generated, and not just hand-converted once

Three reasons, in order of how much they cost when ignored:

1. **The export is the source of truth for the design.** ERA's designer works in
   Webflow. When they re-export, a hand-converted site has to be re-converted by
   hand. A generated one is one command.
2. **The conversion has to be provably faithful.** `tools/verify.php` renders
   every page from the running app, parses it and the original side by side, and
   compares the element tree, the visible text and the image list. That check is
   only meaningful if the conversion is repeatable.
3. **The export has real defects.** Fourteen of the sixteen pages shipped with
   the newsletter button permanently `disabled`, blocks frozen mid-animation at
   `opacity: 0`, a stale Cloudflare Turnstile token, and a dead link with a space
   in the URL. Those fixes live in `tools/lib_rewrite.php` where they are applied
   consistently and documented, rather than scattered through sixteen files.

## Request flow

```
GET /services/paid-advertising
  │
  ├─ routes/web.php ─────────────► Site\PageController::serviceDetails('paid-advertising')
  │                                  └─ Service::published()->where('slug', …)->firstOrFail()
  │
  └─ view: site/pages/service-details.blade.php
       ├─ @extends site/layouts/app.blade.php
       │    ├─ @include site/partials/head     ← setting('general.favicon_id'), page meta
       │    ├─ @include site/partials/navbar   ← cms_menu('primary'), cms_menu('mega')
       │    ├─ @yield('content')               ← the page body
       │    ├─ @include site/partials/footer   ← setting('footer.*'), cms_menu('footer')
       │    └─ @include site/partials/scripts  ← jQuery, Webflow runtime
       │
       └─ body reads, in order of preference:
            $service->title                    ← the record in the URL
            cms('service-details.…', 'default')← the page section, for shared copy
            the literal from the export        ← the fallback argument, always present
```

Every binding keeps the export's own value as its last argument. Clear a field in
the dashboard and the page falls back to what the template shipped with, rather
than rendering a hole.

## Directory map

```
era-website-fullstack/
├── app/
│   ├── Console/Commands/ImportWebflowMedia.php   registers downloaded CDN assets
│   ├── Http/Controllers/
│   │   ├── Admin/       23 controllers; nine of them extend ResourceController
│   │   └── Site/        PageController (public pages), FormController (2 forms)
│   ├── Http/Middleware/EnsureUserHasPermission.php
│   ├── Models/          29 models
│   └── Support/
│       ├── ActivityLogger.php   who changed what
│       ├── Content.php          the CMS read side, memoised per request
│       └── helpers.php          cms(), cms_image(), setting(), cms_menu(), nav_active()
│
├── database/
│   ├── data/            content.json + pages.json — extracted from the export, seeded from
│   ├── migrations/      17
│   └── seeders/         8, run in order by DatabaseSeeder
│
├── docs/                this folder
│
├── public/
│   ├── site/            css, js, fonts, the four local images — served as-is
│   ├── storage → …      symlink to storage/app/public
│   └── build/           Vite output (dashboard only)
│
├── resources/views/
│   ├── admin/           the dashboard — hand-written, edit freely
│   └── site/            GENERATED — see the rule above
│
├── routes/
│   ├── web.php          public site + the two form endpoints
│   └── admin.php        103 dashboard routes, each naming its permission
│
└── tools/               the conversion pipeline; build.php runs all of it
```

## Things that are deliberately not Laravel-idiomatic

Worth knowing before you "fix" them:

- **The public views contain Webflow's inline `style="transform: translate3d(…)"`
  attributes.** Those are IX2's entry states. Webflow's runtime overwrites them
  on load; stripping them makes content invisible if the runtime fails to boot.
- **The commerce cart in the navbar is inert.** It came with the ecommerce
  template and has no backend. It stays because removing it changes the navbar's
  layout. Remove it deliberately, with a rebuild and a verify, or not at all.
- **`{!! !!}` appears in the site views.** Any value that carries markup — a rich
  text answer, the styled `+` after a counter — has to render raw. Values without
  markup use `{{ }}`. `tools/make_dynamic.php` decides which by looking for `<`.
- **The forms have an `action` attribute and that is load-bearing.** Webflow's
  runtime hijacks any form that lacks one. See [05 — Recipes](05-recipes.md).
