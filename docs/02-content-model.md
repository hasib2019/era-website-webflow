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

`is_visible` on a section makes `cms()` return the fallback for every field in
it — useful for hiding a band without deleting its copy.

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
| `Client` | `clients` | the three-row logo marquee |
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
Client::published()->where('row_group', 2)->ordered()->get()
```

Scopes in use: `home`, `about`, `service`, `service-details`, `career`,
`why-choose-us`, plus `general`/`contact` for FAQs.

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

`menus` (3) → `menu_items` (31). `column_heading` groups items into the columns
the design draws:

| Menu | Items | Columns |
|---|---|---|
| `primary` | 5 | — (single row) |
| `mega` | 14 | `Column 1` (7), `Column 2` (5), `Column 3` (2) |
| `footer` | 12 | `PAGES` (5), `COMPANY` (4), `UTILITY` (3) |

```blade
@foreach (cms_menu('footer')->groupBy('column_heading') as $heading => $items)
```

Two `mega` labels contain non-breaking spaces (`Career`, `Career&nbsp;&nbsp;Details`)
because the export did. Retyping them with ordinary spaces makes `verify.php`
fail — it is comparing against markup that has the entity.

## Submissions and audit

| Table | Written by | Read at |
|---|---|---|
| `contact_messages` | the contact form | `/admin/messages` |
| `subscribers` | the footer newsletter | `/admin/subscribers` |
| `job_applications` | nothing yet — no apply form exists in the design | `/admin/applications` |
| `activity_logs` | `ActivityLogger` on every dashboard write | `/admin/activity` |

## Known gap

**Career benefits** are seeded into `benefits` but the page still renders static
markup. The four cards are hand-placed among four images in the order
*item, image, item, image, image, item, image, item* — a layout, not a repeat, so
a single loop cannot reproduce it. Rebuilding that section in the export as a
regular grid would let `tools/wire_repeaters.php` pick it up.
