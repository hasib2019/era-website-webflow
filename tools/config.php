<?php
/**
 * Shared paths for the conversion pipeline.
 *
 * The Webflow export lives outside the Laravel app, so its location is resolved
 * once here. Override it with WEBFLOW_EXPORT_DIR when the export sits elsewhere:
 *
 *   WEBFLOW_EXPORT_DIR=/path/to/era-website php tools/build.php
 */

if (! defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

if (! defined('EXPORT_ROOT')) {
    $configured = getenv('WEBFLOW_EXPORT_DIR');
    $fallback = dirname(APP_ROOT) . '/era-website';

    define('EXPORT_ROOT', rtrim(strtr($configured ?: $fallback, [DIRECTORY_SEPARATOR => '/']), '/'));
}

if (! defined('EXPORT_PAGES')) {
    define('EXPORT_PAGES', EXPORT_ROOT . '/Pages/');
}

if (! defined('SITE_VIEWS')) {
    define('SITE_VIEWS', APP_ROOT . '/resources/views/site/');
}

if (! is_dir(EXPORT_PAGES)) {
    fwrite(STDERR, "Webflow export not found at " . EXPORT_PAGES . "\n");
    fwrite(STDERR, "Set WEBFLOW_EXPORT_DIR to the folder that contains Pages/.\n");
    exit(1);
}
