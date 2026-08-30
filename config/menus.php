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
|   navbar.blade.php   cms_menu('mega')->where('column_heading', 'Column 1') ... 3
|   footer.blade.php   cms_menu('footer')->groupBy('column_heading')
|   navbar.blade.php   cms_menu('primary')                       -- one flat row
|
| So the mega menu's three columns are a closed set (the markup has exactly
| three slots), the footer's are open (it renders a column per distinct
| heading), and the primary menu has none.
|
| Modes:
|   none   flat list; column_heading stays null
|   fixed  only the headings listed here are accepted
|   free   any heading; each distinct one becomes a column on the site
|
*/

return [

    'primary' => [
        'mode' => 'none',
        'help' => 'The row of links across the top of every page.',
    ],

    'mega' => [
        'mode' => 'fixed',
        'columns' => ['Column 1', 'Column 2', 'Column 3'],
        'help' => 'The panel that opens from the menu button. The template has exactly '
            . 'three columns, so an item outside them would not render.',
    ],

    'footer' => [
        'mode' => 'free',
        'help' => 'Grouped by heading. Name a new heading and the footer grows a column '
            . 'for it; empty a heading of all its links and the column disappears.',
    ],

];
