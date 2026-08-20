<?php
require __DIR__ . '/lib_slice.php';
$root = 'd:/ERA/Era-WEBSITE-Templete/era-website/Pages/';
$skip = ['pricing.html', 'terms&conditions.html'];
$parts = [];
foreach (glob($root . '*.html') as $f) {
    $b = basename($f);
    if (in_array($b, $skip, true)) continue;
    $parts[$b] = slice_page(file_get_contents($f));
}
$outDir = 'C:/Users/MDHASI~1/AppData/Local/Temp/claude/d--ERA-Era-WEBSITE-Templete-era-website/d92037e4-7181-499e-a989-3de567deb92a/scratchpad/parts';
@mkdir($outDir, 0777, true);
foreach ($parts as $b => $p) {
    foreach (['navbar', 'footer', 'head', 'scripts', 'cursor'] as $k) {
        // one tag per line so diff output is readable
        $pretty = preg_replace('/>\s*</', ">\n<", $p[$k]);
        file_put_contents("$outDir/" . str_replace('.html', '', $b) . ".$k.txt", $pretty);
    }
}
echo "written to $outDir\n";
