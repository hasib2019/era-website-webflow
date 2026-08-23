# 04 — Admin dashboard

Plain Blade + Tailwind 4, served from `/admin`. No SPA, no build step beyond
Vite compiling `resources/css/admin.css` and `resources/js/admin.js`.

Unlike the public site, **these views are hand-written — edit them freely.**

## Screens

| Path | Permission | Notes |
|---|---|---|
| `/admin` | `dashboard.view` | tiles, recent messages, recent activity |
| `/admin/pages`, `/admin/pages/{slug}` | `pages.view` / `pages.edit` | the section editor |
| `/admin/media` | `media.view` / `.upload` / `.delete` | grid, upload, alt text |
| `/admin/menus`, `/admin/menus/{slug}` | `menus.manage` | link editor per menu |
| `/admin/services` … `/admin/changelog` | one `*.manage` each | nine collection screens |
| `/admin/messages`, `/admin/applications`, `/admin/subscribers` | `messages.view` etc. | the inbox |
| `/admin/users`, `/admin/roles` | `users.*`, `roles.manage` | multi-admin |
| `/admin/activity` | `activity.view` | audit trail with field-level diffs |
| `/admin/settings` | `settings.manage` | grouped key/value editor |
| `/admin/profile` | — | own account, any signed-in admin |

`config/admin_nav.php` drives the sidebar. Each entry names the permission that
reveals it, so a role that cannot reach a screen never sees the link — and the
route enforces it again server-side.

## Roles and permissions

25 permissions in 8 groups (`Dashboard`, `Pages`, `Content`, `Media`,
`Navigation`, `Submissions`, `Settings`, `Administration`). Five seeded roles:

| Role | Reach |
|---|---|
| Super Admin | everything; bypasses the permission table entirely |
| Administrator | all content, media, menus, settings, submissions |
| Editor | pages and collections; no settings, no users |
| Author | blog posts and media uploads only |
| Viewer | read-only |

Roles are editable at `/admin/roles`. The five seeded ones are `is_system` and
cannot be deleted; the super admin role's permission grid is locked because it
holds everything by definition.

### Two guards worth not removing

Both live in `Admin\UserController`:

- an admin cannot deactivate or delete **their own** account;
- the **last active super admin** cannot lose that role or be deleted.

Without them a dashboard can lock everyone out, and the only way back is SQL.

Also: only a super admin can grant the super admin role. `assignableRoles()`
strips it from the submitted list for anyone else, so the checkbox being disabled
in the UI is a courtesy, not the control.

## Adding a collection screen

Nine screens share `Admin\ResourceController` plus two views
(`admin/resource/index.blade.php` and `form.blade.php`). A tenth is a small class:

```php
class AwardController extends ResourceController
{
    protected function model(): string { return Award::class; }
    protected function key(): string { return 'awards'; }

    protected function labels(): array
    {
        return ['singular' => 'Award', 'plural' => 'Awards'];
    }

    protected function columns(): array
    {
        return ['title', 'year', 'is_published'];
    }

    protected function fields(): array
    {
        return [
            'title'        => ['label' => 'Title', 'type' => 'text', 'rules' => 'required|string|max:255'],
            'year'         => ['label' => 'Year',  'type' => 'number', 'rules' => 'nullable|integer'],
            'image_id'     => ['label' => 'Image', 'type' => 'media', 'rules' => 'nullable|exists:media,id'],
            'sort_order'   => ['label' => 'Order', 'type' => 'number', 'rules' => 'nullable|integer|min:0'],
            'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'rules' => 'nullable|boolean'],
        ];
    }
}
```

That gives you the index table, search, the create/edit form, validation, slug
generation and the activity trail. Then:

1. add the permission in `RolePermissionSeeder` and re-seed,
2. add the row to the `$collections` table in `routes/admin.php`,
3. add the sidebar entry in `config/admin_nav.php`.

### Field types the form renderer understands

`text`, `textarea`, `richtext`, `number`, `select`, `checkbox`, `media`, `date`,
`datetime`. A `group` key on a field puts it in its own card
(`'group' => 'SEO'`); fields without one land in "Content".

`slugSource()` returns which field seeds the slug — return `null` for models
without one. `searchable()` lists the columns the index search box covers.

## Conventions

- **Every write goes through `ActivityLogger`.** `ActivityLogger::log('updated',
  $model, null, ActivityLogger::diff($model))` records the user, the action, the
  subject and the field-level before/after, with passwords stripped.
- **Tailwind classes must be literal.** `bg-{{ $tone }}-50` compiles to nothing —
  Tailwind scans source text. Spell each variant out; `admin/partials/flash.blade.php`
  shows the pattern.
- **`resources/css/admin.css` only scans `resources/views/admin/`.** Keep it that
  way: pointing it at the site views would pull Webflow's class names into the
  dashboard bundle and risk Tailwind's reset leaking into the public pages.
- **Icons come from `admin/partials/icon.blade.php`** — a name → SVG path map.
  Add a path there rather than inlining SVG in a view.
