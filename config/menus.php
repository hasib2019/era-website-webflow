<?php

/*
|--------------------------------------------------------------------------
| Menu columns
|--------------------------------------------------------------------------
|
| How each menu groups its items, which is what `menu_items.column_heading`
| holds. This has to match what the site partials actually read, because a
| heading they do not look for is an item nobody ever sees:
|
|   navbar.blade.php   cms_menu('primary')  -- the top bar: a link per item, and
|                                              a panel per item of type dropdown,
|                                              whose columns come from $item->columns()
|   navbar.blade.php   cms_menu('primary')  -- again, for the burger overlay, which
|                                              draws the top level only
|   footer.blade.php   cms_menu('footer')->groupBy('column_heading')
|
| cms_menu() already returns the tree: Menu::tree() takes active top-level items
| with their active children eager-loaded, so a dropdown arrives ready to draw.
|
| The footer's columns are open (it renders a column per distinct heading) and
| the primary row itself has none — but a primary item of type `dropdown`
| groups its own children into columns the same open way.
|
| Modes:
|   none   flat list; column_heading stays null
|   fixed  only the headings listed here are accepted
|   free   any heading; each distinct one becomes a column on the site
|
*/

return [

    /*
     * `dropdowns` lets an item in this menu open a panel instead of navigating.
     * Its children group into columns by heading, the way the footer's do,
     * because .nav-dropdown-list is a flex row rather than a fixed three-column
     * grid — the number of columns follows the content. The panel is 700px wide
     * (600 and 420 at the lower breakpoints), which is about four columns'
     * worth before the links start to crowd.
     *
     * The top level itself stays flat: it is one row across the bar.
     */
    'primary' => [
        'mode' => 'none',
        'dropdowns' => true,
        'help' => 'The row of links across the top of every page. Any item can be turned '
            . 'into a dropdown, in any position — its children become the panel it '
            . 'opens, grouped into columns by heading.',
    ],

    'footer' => [
        'mode' => 'free',
        'help' => 'Grouped by heading. Name a new heading and the footer grows a column '
            . 'for it; empty a heading of all its links and the column disappears.',
    ],

];
