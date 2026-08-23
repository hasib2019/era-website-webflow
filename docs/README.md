# ERA Infotech CMS — documentation

The public site is a Webflow export ("Edoly") rebuilt on Laravel so that ERA can
edit it. The design does not change; only who can change it does.

Read these in order the first time:

| | |
|---|---|
| [01 — Architecture](01-architecture.md) | How the pieces fit, and the one rule that matters |
| [02 — Content model](02-content-model.md) | Settings, page sections, collections — which to use |
| [03 — Build pipeline](03-build-pipeline.md) | Why the views are generated and how to regenerate them |
| [04 — Admin dashboard](04-admin-dashboard.md) | Screens, roles, permissions, adding a new one |
| [05 — Recipes](05-recipes.md) | Step-by-step for the changes you will actually be asked for |
| [06 — Operations](06-operations.md) | Setup, deployment, troubleshooting |
| [07 — Responsive](07-responsive.md) | Where responsive CSS lives, how to measure it, what was corrected |

## The 30-second version

- **`resources/views/site/pages/*.blade.php` is generated.** Hand-edits survive
  until the next `php tools/build.php` and then vanish. Change the export or a
  wiring pass instead — [03](03-build-pipeline.md) explains both.
- **`php tools/verify.php` is the guard rail.** It renders every page and
  compares it to the original export. It must say
  *"all pages structurally identical"*. If it does not, something drifted.
- **Content lives in three places** — site settings, page sections, and
  collections. [02](02-content-model.md) tells you which one a given piece of
  copy belongs in.
- **The admin dashboard is plain Blade + Tailwind.** Nine of its screens share
  one controller and one pair of views; adding a tenth is a small class, not a
  new UI — see [04](04-admin-dashboard.md).
