<?php
require __DIR__ . '/lib_slice.php';
$root = 'd:/ERA/Era-WEBSITE-Templete/era-website/Pages/';
$skip = ['pricing.html', 'terms&conditions.html'];
printf("%-26s %8s %8s %8s %8s %8s %8s\n", 'PAGE', 'head', 'preNav', 'cursor', 'navbar', 'content', 'footer');
foreach (glob($root . '*.html') as $f) {
    $b = basename($f);
    if (in_array($b, $skip, true)) continue;
    try {
        $p = slice_page(file_get_contents($f));
        printf("%-26s %8d %8d %8d %8d %8d %8d\n", $b, strlen($p['head']), strlen($p['pre_nav']), strlen($p['cursor']), strlen($p['navbar']), strlen($p['content']), strlen($p['footer']));
    } catch (Throwable $e) {
        printf("%-26s  ERROR: %s\n", $b, $e->getMessage());
    }
}
