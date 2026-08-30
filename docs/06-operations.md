# 06 — Operations

## Requirements

| | |
|---|---|
| PHP | 8.2+ with `zip`, `gd`, `intl`, `fileinfo`, `pdo_mysql` |
| Laravel | 12.x — **13 needs PHP 8.3+**, so upgrading PHP comes first |
| MySQL | 5.7+ / MariaDB 10.3+, `utf8mb4` |
| Node | 20+ (dashboard assets only; the public site ships no build output) |

The development machine runs XAMPP at `D:\XAMPP-8`. MySQL is not on `PATH` and
does not start on boot:

```bash
D:/XAMPP-8/mysql/bin/mysqld.exe --defaults-file=D:/XAMPP-8/mysql/bin/my.ini --standalone
D:/XAMPP-8/mysql/bin/mysql.exe -u root era_website        # the client
```

`zip`, `gd` and `intl` were enabled in `D:\XAMPP-8\php\php.ini`; a timestamped
backup of the original sits beside it.

## First run

```bash
composer install
npm install && npm run build
cp .env.example .env && php artisan key:generate     # then set DB_* and APP_URL
php artisan migrate --seed
php artisan serve
```

Seeding runs eight seeders in order: roles and permissions, admin users,
settings, menus, collections, page sections, per-record detail content.

`db:seed` imports the media library first, because the content seeders resolve
image filenames to media ids — seed before the library exists and every record
comes out with a null image. To re-run the import on its own:

```bash
php artisan media:import-webflow
```

It is idempotent; files already registered are skipped.

## Environment

| Key | Notes |
|---|---|
| `APP_URL` | must match how the site is served, or `asset()` URLs break |
| `DB_*` | MySQL; the schema assumes `utf8mb4` |
| `FILESYSTEM_DISK` | **must be `public`** — the media library writes there |
| `FILESYSTEM_PUBLIC_URL` | only if uploads move to a CDN; defaults to `/era` |
| `SEED_ADMIN_PASSWORD` | password for the seeded accounts; default `Era@2026!` |
| `WEBFLOW_EXPORT_DIR` | only for the build tools; defaults to `../era-website` |
| `VERIFY_BASE_URL` | only for `verify.php`; defaults to `http://127.0.0.1:8000` |

## Seeded accounts

| Email | Role |
|---|---|
| superadmin@erainfotechbd.com | Super Admin |
| admin@erainfotechbd.com | Administrator |
| editor@erainfotechbd.com | Editor |
| author@erainfotechbd.com | Author |

All four share `SEED_ADMIN_PASSWORD`. **Change them before this is reachable from
anywhere but localhost**, and delete the ones you do not need.

## Deploying

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Point the web root at `public/`. Make `storage/`, `bootstrap/cache/` and
`public/era/` writable — `public/era/` is where the media library saves
uploads, served directly as `/era/...` with no `storage:link` involved.

The build tools are development-only — `tools/` and the Webflow export do not
need to ship. Regenerate views locally, commit them, deploy the result.

If you cache views in production, remember `php artisan view:clear` after any
deploy that changes the site views.

## Database engine (read before the first deploy)

The schema needs **InnoDB with `ROW_FORMAT=DYNAMIC`**. Two settings enforce it,
and both must reach the server:

| Where | What |
|---|---|
| `config/database.php` | `'engine' => env('DB_ENGINE', 'InnoDB ROW_FORMAT=DYNAMIC')` |
| `app/Providers/AppServiceProvider.php` | `Schema::defaultStringLength(191)` |

Why both:

- MyISAM **silently discards foreign keys**. This schema has 25 of them doing
  cascade deletes, so on MyISAM they would simply not exist.
- MyISAM caps an index at 1000 bytes and older InnoDB row formats at 767. The
  composite unique keys on `settings (group, key)` and `media (disk, path)` come
  to 1528 bytes even at 191 characters. `ROW_FORMAT=DYNAMIC` raises the limit to
  3072, which fits. **The 191 setting on its own is not enough.**

Check what a server actually did:

```sql
SELECT engine, row_format, COUNT(*) FROM information_schema.tables
 WHERE table_schema = DATABASE() GROUP BY engine, row_format;

SELECT COUNT(*) FROM information_schema.table_constraints
 WHERE table_schema = DATABASE() AND constraint_type = 'FOREIGN KEY';
```

Expect every table `InnoDB / Dynamic`, and 25 foreign keys.
## Troubleshooting

**`SQLSTATE[42000]: 1071 Specified key was too long; max key length is 1000 bytes`**
The tables are being created as MyISAM — 1000 bytes is its signature, and the
failing `CREATE TABLE` in the error will have no `ENGINE=` clause. The server is
running without the two settings above: either they were not deployed, or a
cached config is still in play.

```bash
php artisan config:clear          # or config:cache to rebuild it
php artisan migrate:fresh --force # the failed run leaves MyISAM tables behind
```

`migrate:fresh` drops every table in the database. On a first deploy that is
what you want; on a live one, drop the partial tables by hand instead.
**A page shows the template's old wording after an edit.**
The compiled view is stale, or the field is not bound. `php artisan view:clear`
first; if it persists, grep the view for `cms('page.section.field'` — if it is
not there, the field was never wired.

**Everything on the site lost its styling.**
`public/site/css/styles.css` is missing or `APP_URL` is wrong. Check
`/site/css/styles.css` returns 200.

**Animations stopped; content is invisible.**
Webflow's runtime did not load. Check `/site/js/schunk.js` and
`/site/js/webflow.js` return 200 — the entry states are `opacity: 0` and only the
runtime clears them.

**A form does nothing, or the page reloads with no message.**
The form lost its `action` attribute, so Webflow's runtime swallowed the submit.
Re-run `php tools/wire_forms.php`.

**An image 404s.**
The filename contains a space, `%20` or parentheses. Rename it on disk, update
the `media` row, and re-run the build.

**`verify.php` fails after a change you meant to make.**
That is the tool working. Read `-v`, confirm the differences are yours, and if
the design genuinely changed, the export is the new baseline.

**`php tools/build.php` says the export is not found.**
It looks for `../era-website/Pages/`. Point `WEBFLOW_EXPORT_DIR` at the right
folder.

**The dashboard 500s on one screen only.**
Usually a value that is not a string being cast to one — activity-log diffs hold
arrays for JSON columns. `storage/logs/laravel.log` has the line.

## Health checks

```bash
php artisan about                 # framework, cache, database
php artisan route:list            # 103 admin routes + the public ones
php tools/verify.php              # the site still matches the export
php tools/probe.php               # per-page slice sizes, for spotting odd pages
```
