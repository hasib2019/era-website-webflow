# 02 — Content model

Content sits in one of three layers. Picking the wrong one is the most common way
to make this codebase annoying, so start here.

## Which layer does this belong in?

| Ask | Layer | Example |
|---|---|---|
| Is it the same on every page? | **Setting** | logo, footer copyright, social links |
| Is it one specific band of one specific page? | **Page section** | the home hero's three headline lines |
| Does it repeat, or does it have its own URL? | **Collection** | services, blog posts, testimonials |

If two of these seem to fit, prefer the more specific one. Copy that only ever
appears in one place on one page is a page section, even if it looks global.

---

## Layer 1 — Settings

One flat key/value table, grouped. Read on nearly every request, so it is cached
until something writes to it.

```php
setting('footer.copyright', '© All rights reserved.')
setting_image('general.logo_dark_id', '/site/images/fallback.svg')
```

Groups as seeded: `general` (6), `seo` (3), `contact` (5), `social` (5),
`footer` (7). Edited at `/admin/settings`, which renders whatever rows exist —
adding a setting means adding a row, not a form field.

A setting whose `type` is `media` stores a `media.id`; `setting_image()` resolves
it to a URL.

## Layer 2 — Page sections

`pages` (16 rows) → `page_sections` (83 rows). A section's `content` column is a
JSON map:

```json
{
  "hero_title_line_1": { "type": "text",  "value": "provide The" },
  "hero_image":        { "type": "image", "value": "home-hero-image.jpg" }
}
```

Read from a view with a dotted path and a fallback:

```blade
{{ cms('home.home_hero.hero_tagline', 'Marketing Design Agency since 1988') }}
{{ cms_image('home.home_hero.hero_image', '/site/images/home-hero-image.jpg') }}
```

`type` drives the editor at `/admin/pages/{slug}`: `image` and `icon` render a
media picker, `richtext` and `html` a code box, everything else a text input. The
editor only writes keys that already exist in `content`, so a stray form field
cannot invent one.

`is_visible` on a section makes `cms()` return `''` for every field in it, so the
band's copy disappears without its rows being deleted. It returns empty rather
than the export's literal on purpose: the one control meant to remove content
must not put the original back.

`tools/wire_section_visibility.php` wraps each section in
`@if(cms_section_visible(...))`, so hiding a band now removes its markup rather
than leaving an empty shell of icons and layout wrappers behind.

### The navbar carries two navigations

`site/partials/navbar.blade.php` renders the Primary menu twice, and until
`tools/wire_chrome.php` existed only one of them was bound:

| | class | bound by |
|---|---|---|
| overlay menu, behind the burger | `nav-main-menu-wrap` | `wire_navbar.php` |
| the link row visitors actually click | `nav-link-wrap` | `wire_chrome.php` |

Both read `cms_menu('primary')`, so one menu drives both — but not identically:
the row draws the top level (a dropdown becomes a panel), while the overlay
flattens to the leaf links, because it is the only navigation below 992px.
Neither class carries a `text-transform`, so labels render exactly as typed —
the seed data was changed from `home` / `about us` to `Home` / `About` for that
reason.

### Page SEO

`pages.meta_title`, `meta_description` and `og_image_id` reach the markup by three
different routes, because the head partial offers three different hooks:

| | how |
|---|---|
| `<title>` | `page_title($slug, $literal)` in each page's `@section('title', …)`, written by `tools/wire_seo.php` |
| detail pages | `detail_title($record, $slug, $literal)` — the job or service in the URL wins over the page row |
| description, og:image | the `$site` composer in `AppServiceProvider`, cascading page → `seo.*` settings → the export's literal |

`$site` is what `site/partials/head.blade.php` has always read. Nothing defined it
until that composer existed, so `general.favicon_id`, `general.webclip_id`,
`seo.og_image_id`, `seo.meta_title` and `seo.meta_description` were all editable
in the dashboard and reached nothing.

### Field types in use

`text`, `richtext`, `html`, `image`, `icon`, `video`, `url`, `number`, `boolean`

## Layer 3 — Collections

Real tables with real columns, listed and edited at their own dashboard screen.

| Model | Table | Drives |
|---|---|---|
| `Service` | `services` | services list + `/services/{slug}` |
| `ServiceFeature` | `service_features` | the feature list on a service page |
| `CaseStudy` | `case_studies` | case study grid + `/case-studies/{slug}` |
| `CaseStudyStrategy` | `case_study_strategies` | the alternating strategy blocks |
| `CaseStudyResult` | `case_study_results` | the result stat row |
| `Post` | `posts` | blog list, featured post, `/blog/{slug}` |
| `PostCategory` | `post_categories` | post grouping |
| `JobOpening` | `job_openings` | careers list + `/career/{slug}` |
| `Testimonial` | `testimonials` | the tab slider on six pages |
| `TeamMember` | `team_members` | the about page team grid |
| `Client` | `clients` | the three-row logo marquee, plus the about page’s partners and certifications bands (by `scope`) |
| `CoreValue` | `core_values` | the numbered circles in the about page’s core values band |
| `Award` | `awards` | the about page’s awards & achievements list |
| `Faq` | `faqs` | the accordion, filtered by `scope` |
| `ProcessStep` | `process_steps` | the numbered strips, filtered by `scope` |
| `Stat` | `stats` | the animated counters, filtered by `scope` |
| `Benefit` | `benefits` | career benefits (data only — see below) |
| `ChangelogEntry` | `changelog_entries` | the changelog page |

### `scope` and `row_group`

Several blocks appear on more than one page with different content. Rather than
one table per page, those models carry a `scope`:

```php
ProcessStep::forScope('home')->ordered()->get()      // home
ProcessStep::forScope('service')->ordered()->get()   // services page
Stat::forScope('career')->ordered()->get()           // careers page
Client::published()->forScope('client')->where('row_group', 2)->ordered()->get()
```

Scopes in use: `home`, `about`, `service`, `service-details`, `career`,
`why-choose-us`, plus `general`/`contact` for FAQs and
`client`/`partner`/`certification` for the three logo bands.

The logo bands are the one place where forgetting a scope is silently wrong
rather than empty: the marquee filters on `row_group`, so a partner row created
with `row_group` 1 turns up mid-marquee unless the query also says
`forScope('client')`.

### Shared query scopes

Most collection models expose the same two, so views read alike:

```php
Model::published()   // where is_published = true
Model::ordered()     // order by sort_order, then id
```

`Post` swaps `ordered()` for `latestFirst()` (newest `published_at` first).

---

## Media

`media` (56 rows) is the library behind every image picker. Rows came from two
places: `php artisan media:import-webflow` registered the 127 files pulled off
Webflow's CDN, and uploads through `/admin/media` add more.

Webflow ships each image with `-p-500`, `-p-800` … downscales. The import folds
those into the parent row's `variants` JSON rather than listing them separately,
so the library shows 56 entries for 127 files.

A media reference in a page section is stored as a **filename**; in a settings row
or a model column it is a **media id**. `Content::mediaUrl()` accepts either, plus
an already-usable path, so both work:

```php
cms_image('home.home_hero.hero_image')   // filename  -> URL
setting_image('general.logo_dark_id')    // media id  -> URL
$service->image?->url                    // relation  -> URL
```

## Menus

`menus` (2) → `menu_items` (31). `column_heading` groups items into the columns
the design draws:

| Menu | Items | Columns |
|---|---|---|
| `primary` | 6 top level (+14 children) | — for the row; each dropdown groups its own children |
| `footer` | 12 | `PAGES` (5), `COMPANY` (4), `UTILITY` (3) |

```blade
@foreach (cms_menu('footer')->groupBy('column_heading') as $heading => $items)
```

### The top bar is one menu, links and panels together

`menu_items.type` is `link` or `dropdown`. A dropdown draws a panel from its
own children instead of navigating, so a panel can sit at any position in the
row and both kinds are built on one screen. `parent_id` and `children()` had
been on the model since the start with nothing setting them; a `type` was all
that was missing.

There used to be a second `mega` menu feeding a hard-coded "Other page" toggle
at the end of the row. `2026_01_01_001800_fold_mega_menu_into_primary` moves
those rows under an ordinary dropdown item and drops the menu.

```php
$item->isDropdown()   // draw the panel rather than a link
$item->columns()      // children grouped by heading, one column each
$menu->board()        // the drag targets: top row, then each dropdown's columns
```

A dropdown's column headings are free text and are **not** rendered — they only
say which links share a column. `.nav-dropdown-list` is a flex row, so the count
follows the content; the panel is 700px wide, which is about four columns.

Menus are two levels deep. `MenuController::reorder()` refuses a drop that would
nest a dropdown inside another, because its own children would then point at
something the navbar never opens and would silently vanish from the site.

**The burger overlay draws the leaves, not the top level.** `.nav-menu` is
`display: none` below 992px, so the overlay is the only navigation on a phone;
drawing only the top level would make every link inside a panel unreachable
there, and drawing the panel's own item would offer a link to `#`. Hence
`cms_menu('primary')->flatMap(fn ($i) => $i->isDropdown() ? $i->children : [$i])`
in `navbar.blade.php`.

Two labels inside the "Other page" dropdown contain non-breaking spaces (`Career`, `Career&nbsp;&nbsp;Details`)
because the export did. Retyping them with ordinary spaces makes `verify.php`
fail — it is comparing against markup that has the entity.

## Submissions and audit

| Table | Written by | Read at |
|---|---|---|
| `contact_messages` | the contact form | `/admin/messages` |
| `subscribers` | the footer newsletter | `/admin/subscribers` |
| `job_applications` | the apply form on `/career/{slug}` | `/admin/applications` |
| `activity_logs` | `ActivityLogger` on every dashboard write | `/admin/activity` |

### Uploaded CVs

`job_applications.resume_path` points at the **`local`** disk
(`storage/app/private`), not the public one. A CV is personal data, so no URL
reaches it: `/admin/applications/{id}/resume` is the only way in, and it sits
behind `applications.view` like the list itself. The file is written only after
validation passes and is named from a random string, so nothing about the
uploader's own filename is trusted. `mimes:pdf,doc,docx` and `max:5120` bound
what is accepted.

## Known gap

**Career benefits** are seeded into `benefits` but the page still renders static
markup. The four cards are hand-placed among four images in the order
*item, image, item, image, image, item, image, item* — a layout, not a repeat, so
a single loop cannot reproduce it. Rebuilding that section in the export as a
regular grid would let `tools/wire_repeaters.php` pick it up.
