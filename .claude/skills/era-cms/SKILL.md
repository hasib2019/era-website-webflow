---
name: era-cms
description: Working on the ERA Infotech Laravel CMS (era-website-fullstack) — the Webflow "Era" export rebuilt on Laravel 12. Load before editing anything under resources/views/site, tools/, public/site/css, the admin dashboard, the content models, or the seed data — including any responsive, layout or design change. Covers the generated-views rule, the verify guard, the three content layers, and the Webflow runtime behaviour the markup depends on.
---

# ERA Infotech CMS

A Webflow export rebuilt on Laravel 12 so ERA can edit it. The design does not
change; only who can change it does. Full docs: `docs/README.md`.

## Rule one: the site views are generated

`resources/views/site/pages/*.blade.php` and `resources/views/site/partials/*`
are produced by `php tools/build.php`. **Never hand-edit them.** A hand edit
works until the next rebuild and then disappears with no error.

| Want to change | Edit |
|---|---|
| the markup / design | `era-website/Pages/*.html`, then rebuild |
| what fills the markup | a pass in `tools/`, then rebuild |
| the dashboard | `resources/views/admin/**` — hand-written, edit freely |

## Rule two: verify after every site change

```bash
php artisan serve                        # verify needs the app running
php tools/build.php --verify
```

It must end with **`all pages structurally identical`**. The checker renders all
16 pages, parses them against the original export, and compares the element
skeleton (tag, classes and **depth**), the visible text and the image list. `php tools/verify.php -v` shows
what differs per page.

If you deliberately changed the design, verify will fail and that is correct —
read `-v`, confirm every difference is one you meant, and move on. The export is
the baseline, so once it reflects the new design the check goes green again.

## Where content lives

Three layers. Picking the wrong one is the usual mistake.

```php
setting('footer.copyright', 'fallback')            // same on every page
cms('home.home_hero.hero_tagline', 'fallback')     // one band of one page
Service::published()->ordered()->get()             // repeats, or has its own URL
```

Also: `cms_image()`, `setting_image()`, `cms_menu('primary'|'mega'|'footer')`,
`nav_active('/about')`. All defined in `app/Support/helpers.php`, backed by
`app/Support/Content.php`.

**Every binding keeps the export's literal as its last argument.** Preserve that
when editing a wiring pass — it is what covers a page the seeder never reached
and a key a section never declared.

It is *not* a floor under the dashboard. Where an input exists, what it holds
wins, including when it holds nothing: a cleared field and a hidden section both
render empty. `Content` draws that line with null (no input maps here) versus ''
(an input maps here and is empty). Expect verify to flag any field the client
blanks — that is the feature working.

## Webflow facts the markup depends on

Do not "clean these up":

- **Forms need an `action`.** Webflow's runtime reads every form on load and only
  takes it over when `action` is missing. `method="POST"` + `action` + `@csrf`
  hands submission back to the browser. See `tools/wire_forms.php`.
- **Inline `style="transform: translate3d(…)"` is IX2's entry state.** The
  runtime overwrites it on load. Removing it makes content invisible when the
  runtime fails to boot; `settle_ix2()` already normalises the frozen ones.
- **Tab ids are generated and paired.** A testimonial slide's link and pane are
  tied by `w-tabs-0-data-w-tab-N` / `-pane-N`. Looping means regenerating both
  from `$loop->index` — `tools/wire_testimonials.php`.
- **A counter is markup, not text.** Each digit is a column of 0-9; even-index
  columns park on their first entry (`align-top`), odd on their last
  (`align-bottom`). `resources/views/site/partials/stat-counter.blade.php`
  generates it from `Stat::value`.
- **Two menu labels contain non-breaking spaces** (`Career`,
  `Career&nbsp;&nbsp;Details`). Retyping them with ordinary spaces fails verify.

## Responsive and CSS

`public/site/css/styles.css` is the export and stays byte-identical. Corrections
go in `public/site/css/responsive-fixes.css`, loaded after it.

```bash
node tools/responsive-audit.mjs      # must end "16/16 pages clean"
node tools/screenshot.mjs / home 390,768,1366
```

**`chrome --headless --window-size=390 --screenshot` does not emulate a mobile
viewport.** It lays the page out for desktop and crops it, which looks exactly
like broken responsive CSS. Use `tools/screenshot.mjs`, which sets a real
viewport with `isMobile`.

Be sparing with the audit's `BY_DESIGN` ignore list — two real bugs hid behind it
on the first pass. Details in `docs/07-responsive.md`.
## Writing a wiring pass

The passes in `tools/wire_*.php` all follow one shape. The four things that
actually go wrong:

1. **Match a whole class token**, never a substring:
   `class="(?:[^"]*\s)?the-class(?:\s[^"]*)?"`.
   `blog-collection-item` as a substring also matches
   `feature-blog-collection-item`.
2. **Match tags generically** — `<(?P<tag>[a-z][a-z0-9]*)[^>]*\sclass="…"`.
   `[a-z]+` misses `<h3>`, and Webflow often emits `id` before `class`.
3. **Check the cards are adjacent** before replacing a run from first to last,
   or markup sitting between them is swallowed. `contiguous()` in
   `wire_repeaters.php`.
4. **Use the second card as the template when the first carries an extra class**
   (e.g. `margin-left-none`), then re-add it with `$loop->first`.
5. **Close what you opened.** Splice with `substr($html, $end)` rather than
   appending a hand-counted `</div>`. Getting this wrong reparented the footer's
   bottom row into a two-column grid and pushed two link columns off screen at
   every laptop width.

Register any new pass in `tools/build.php`.

## Adding a dashboard collection screen

Nine screens share `Admin\ResourceController` and two views. A tenth is a small
subclass declaring `model()`, `key()`, `labels()`, `columns()`, `fields()` — then
a permission in `RolePermissionSeeder`, a row in `routes/admin.php`'s
`$collections` table, and an entry in `config/admin_nav.php`.
Details in `docs/04-admin-dashboard.md`.

## Database engine

The schema needs **InnoDB with `ROW_FORMAT=DYNAMIC`**, forced in
`config/database.php`, plus `Schema::defaultStringLength(191)` in
`AppServiceProvider`. MyISAM silently drops the 25 foreign keys, and its
1000-byte index cap rejects the composite uniques on `settings` and `media`
(1528 bytes). **191 alone does not fix it** — the engine does.

`1071 Specified key was too long ... 1000 bytes` on deploy means those settings
did not reach the server: `php artisan config:clear`, then
`php artisan migrate:fresh --force` to clear the MyISAM tables the failed run
left behind. See `docs/06-operations.md`.

## Environment

PHP 8.2 via XAMPP at `D:\XAMPP-8`. MySQL is not on `PATH` and is not running by
default:

```bash
D:/XAMPP-8/mysql/bin/mysqld.exe --defaults-file=D:/XAMPP-8/mysql/bin/my.ini --standalone
D:/XAMPP-8/mysql/bin/mysql.exe -u root era_website
```

PHP 8.2 caps this at Laravel 12; Laravel 13 needs 8.3+.

## Read next

| | |
|---|---|
| `docs/01-architecture.md` | how the pieces fit, and why generated |
| `docs/02-content-model.md` | the three layers, every table, `scope` and `row_group` |
| `docs/03-build-pipeline.md` | each tool, the deliberate deviations, reading a verify failure |
| `docs/04-admin-dashboard.md` | screens, roles, the two lockout guards |
| `docs/05-recipes.md` | step-by-step for the common asks |
| `docs/06-operations.md` | setup, deploy, troubleshooting |
| `docs/07-responsive.md` | responsive CSS, the audit tool, the screenshot trap |
