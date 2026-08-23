# 05 — Recipes

Step-by-step for the changes you will actually be asked for. Every recipe that
touches the public site ends the same way: rebuild, then verify.

---

## Change wording or a picture on a live page

No code. Sign in at `/admin`, open the page under **Pages**, edit the section,
save. If the copy is not on that screen it is not a page section yet — see the
next recipe.

---

## Make a piece of static text editable

Say the services page shows a caption that is still hard-coded.

1. **Add the field to the section's content.** Either edit
   `database/data/pages.json` and re-seed, or add it directly:

   ```php
   php artisan tinker
   >>> $s = App\Models\PageSection::whereKey(12)->first();
   >>> $c = $s->content;
   >>> $c['caption'] = ['type' => 'text', 'value' => 'OUR SERVICES'];
   >>> $s->update(['content' => $c]);
   ```

   The page editor renders whatever keys exist, so the input appears immediately.

2. **Bind it in the view.** Add the mapping to `tools/make_dynamic.php`, or if
   the text is awkward to match, add a one-line replacement in a wiring pass.

3. `php tools/build.php --verify`

Fields whose value carries markup must render with `{!! !!}`; plain text uses
`{{ }}`. `make_dynamic.php` decides by looking for `<` in the value.

---

## Change the design of a public page

The views are generated, so the design lives in the export.

1. Edit `era-website/Pages/<page>.html` — or re-export from Webflow over it.
2. `php tools/build.php`
3. `php tools/verify.php`

**verify will now fail, and that is correct** — you changed the design, so the
rendered page no longer matches the old export. Read the `-v` output and confirm
every difference is one you meant. The check compares against the *current*
export, so once you are happy, the new export is the new baseline and verify goes
green again on the next run.

If a wiring pass was matching markup you moved or renamed, it will report
`skipped` or `not found`. Fix the selector in that pass — do not patch the
generated view.

---

## Add a new public page

1. Put the new HTML in `era-website/Pages/awards.html`, built from a copy of an
   existing page so it keeps the navbar and footer blocks the slicer looks for.
2. Register it in `tools/convert.php`'s `$PAGES` map:
   `'awards.html' => ['awards', 'Awards'],`
3. Add its URL in `tools/lib_rewrite.php`'s `link_map()` so links to it rewrite.
4. Add a route and controller method in `routes/web.php` /
   `Site\PageController`.
5. Add a `pages` row and its sections (a `Page` record plus `PageSection` rows).
6. Add it to `verify.php`'s `$PAGES` map so it is checked from then on.
7. `php tools/build.php --verify`

---

## Add a collection and its dashboard screen

1. **Migration + model.** Give the model `published()` and `ordered()` scopes and
   `getRouteKeyName(): 'slug'` if it has one.
2. **Dashboard screen** — a `ResourceController` subclass; see
   [04](04-admin-dashboard.md).
3. **Permission** in `RolePermissionSeeder`, then re-seed.
4. **Route** in the `$collections` table in `routes/admin.php`.
5. **Sidebar** entry in `config/admin_nav.php`.
6. **Bind the public block** — see the next recipe.

---

## Make a repeating block read from a collection

Add an entry to `tools/wire_collections.php`:

```php
[
    'views'      => ['about'],
    'item_class' => 'award-collection-item',
    'source'     => "\App\Models\Award::published()->ordered()->get()",
    'as'         => 'award',
    'text'       => [
        'award-title' => '$award->title',
        'award-year'  => '$award->year',
    ],
    'image'       => "\$award->image?->url",
    'image_class' => 'award-image',      // when the card holds more than one <img>
    'href'        => "route('awards.show', \$award->slug)",
],
```

Then `php tools/build.php --verify`.

If verify reports the same value repeated, the class did not match — check
whether the element is a heading (`<h3>`) or carries an `id` before its `class`.
If it reports missing elements, the cards were not adjacent and the replacement
swallowed something between them; `wire_repeaters.php` has the `contiguous()`
guard for that case.

---

## Fix a responsive problem

1. **Measure it.** `node tools/responsive-audit.mjs` names the element, the width
   and how far it overflows. Add widths with `WIDTHS=\"320,360,390\"` if the report
   comes from a specific device.
2. **Look at it** with `node tools/screenshot.mjs <path> name <width>` — never
   with `chrome --headless --window-size`, which crops a desktop layout and
   invents problems that are not there.
3. **Find the rule** in `styles.css`; the breakpoint ladder for that class
   usually shows the gap.
4. **Add a block to `public/site/css/responsive-fixes.css`**, with a comment
   saying what breaks without it and at which widths. Leave `styles.css` alone.
5. `node tools/responsive-audit.mjs` until it says `16/16 pages clean`, then
   `php tools/verify.php` to confirm the markup did not move.

If the audit blames something the template animates on purpose, check the
`BY_DESIGN` list at the top of the script before adding to it — it is meant to
stay short.

---
## Change the dashboard's look

Ordinary Laravel work — `resources/views/admin/**` is hand-written.

- Layout: `admin/layouts/app.blade.php`
- Sidebar: `admin/partials/sidebar.blade.php` + `config/admin_nav.php`
- Shared table/form: `admin/resource/{index,form,field,cell}.blade.php` — editing
  these changes all nine collection screens at once
- Theme tokens: `resources/css/admin.css` (`--color-brand-*`)

Then `npm run build`. Remember Tailwind only sees literal class strings.

---

## Add a form

The template's forms work because they have an `action`. Webflow's runtime reads
each form on load and only takes it over when `action` is absent:

```js
var _ = c.action = l.attr('action');
if (!_) { /* Webflow handles it */ }
```

So a Laravel form needs `method="POST"`, an `action`, and `@csrf`. Follow
`tools/wire_forms.php`:

1. add the route and a controller method,
2. add an entry to `$FORMS` naming the form's `data-name`, its route, and which
   inputs to repopulate,
3. validate into a named bag (`validateWithBag('contact', …)`) so each form shows
   only its own errors,
4. rebuild.

Keep the inputs' original Webflow names (`First-name`, `field`) and map them in
the controller — renaming them is churn in generated markup for no gain.

The template's own success and error panels (`.w-form-done`, `.w-form-fail`) are
hidden by Webflow's CSS; the wiring adds an inline `display:block` when the
matching flash is present.

---

## Replace an image everywhere

Upload the new file at `/admin/media`, then point the field at it — a page
section's image picker, a settings row, or the model's `image_id`. Nothing needs
a rebuild; media is read at request time.

To pull in a fresh batch of Webflow assets, drop the files into
`storage/app/public/media/webflow/` and run:

```bash
php artisan media:import-webflow
```

Filenames with spaces, `%20` or parentheses break static file serving — rename
them before importing.

---

## Remove the Webflow commerce cart

It is inert but visible. Removing it changes the navbar layout, so do it
deliberately:

1. delete the cart block from `era-website/Pages/*.html` (or set
   `$showCart = false` per page, which `convert.php` already understands),
2. `php tools/build.php`,
3. `php tools/verify.php` — it will flag the removal; confirm that is all it
   flags,
4. drop `resources/views/site/partials/cart.blade.php` and its `@include` from
   `convert.php` once the export no longer contains it.

---

## Reset everything

```bash
php artisan migrate:fresh --seed
php tools/build.php --verify
```

Seeding imports the media library first; the content seeders need it to resolve
image filenames to media ids.

`migrate:fresh` drops the submissions and the activity log too. On anything with
real data, seed selectively:

```bash
php artisan db:seed --class=MenuSeeder
```
