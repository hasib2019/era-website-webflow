<?php
/**
 * The inventory captured some copy straight from the markup, so entities like
 * &amp; and &nbsp; were stored literally. Blade escapes on output, which would
 * encode them a second time. Plain-text values are decoded here once, so
 * {{ }} re-encodes them back to exactly what the export contained.
 *
 * Values that carry real markup are left alone; those render raw.
 */

$file = __DIR__ . '/../database/data/pages.json';
$pages = json_decode(file_get_contents($file), true);
$decoded = 0;

foreach ($pages as &$page) {
    foreach ($page['sections'] as &$section) {
        foreach ($section['content'] as &$definition) {
            $value = (string) ($definition['value'] ?? '');

            if ($value === '' || str_contains($value, '<')) {
                continue;
            }

            $plain = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

            if ($plain !== $value) {
                $definition['value'] = $plain;
                $decoded++;
            }
        }
    }
}
unset($page, $section, $definition);

file_put_contents($file, json_encode($pages, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
echo "decoded $decoded value(s)\n";
