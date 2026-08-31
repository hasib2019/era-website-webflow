# 08 — Animations

Every motion on the public site — the reveals, the scroll-driven video zoom, the
hover rolls, the testimonial tabs, the counters — comes from Webflow's
interactions runtime (IX2), shipped in `public/site/js/schunk.js`. None of it is
ours. The job is not to write animations but to avoid breaking the ones the
export already has.

## How IX2 finds its work

Two things, and losing either is silent:

| | |
|---|---|
| `data-w-id` on an element | binds that element's own interactions — hover, reveal on scroll |
| `data-wf-page` / `data-wf-site` on `<html>` | loads the **page-scoped** animations: the scroll-driven ones |

The second is the dangerous one. Drop `data-wf-page` and element-level reveals
keep working perfectly while every scroll-scrubbed animation dies — the video
never grows, the process strip never appears. The page looks *half*-animated,
which reads as a CSS problem rather than a missing attribute.

That is exactly what happened here: the layout was rebuilt without those two
attributes, and it took a scroll-position trace against the export to find it.

## Checking

```bash
php artisan serve
npm run interactions      # node tools/interactions-check.mjs
```

For each page it loads the rendered page and the export page it was built from,
reads IX2's own store, and compares:

- how many event subscriptions IX2 actually registered,
- how many events the interaction data holds,
- the `data-wf-page` id.

It must end with `12/12 pages bind the same interactions as the export`. A drop
in subscriptions means some element's `data-w-id` was lost, duplicated or
reparented by a wiring pass.

`verify.php` also compares `data-wf-page` and `data-wf-site` now, so a missing id
fails the ordinary fidelity check too.

## Why verify.php could not see it

`skeleton()` walks `//body//*`. The attributes live on `<html>`, outside that
scope entirely, and the markup inside `<body>` was byte-perfect. A check that
compares structure will never catch a behavioural regression on its own — which
is why the interactions guard exists alongside it.

## Do not "settle" the inline transforms

The export ships elements mid-animation: `translate3d(0, 60px, 0)` with
`opacity: 0`. That looks like broken markup and is tempting to normalise.

It was normalised once, by a `settle_ix2()` pass, on the theory that content
should stay visible if the runtime never boots. Measuring the running page showed
IX2 re-applies its own initial state on load, so the rewrite achieved nothing —
and its opacity pattern only matched when the declarations came in one order, so
elements written the other way round kept `opacity: 0` while losing their offset.
Those never revealed at all.

The inline styles are now copied through exactly. The no-JS case is covered by a
`<noscript>` rule in `resources/views/site/partials/head.blade.php`.

## When you touch markup that animates

1. Rebuild: `php tools/build.php --verify`
2. Check the animations: `npm run interactions`
3. If something looks wrong but both pass, trace it by scroll position — load the
   rendered page and the export side by side, step the scroll down in fixed
   increments and compare the computed `transform` and `opacity` at each stop.
   A scrubbed animation that never moves is a binding problem; one that moves
   differently is a layout problem.
