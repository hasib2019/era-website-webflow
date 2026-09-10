<?php
/**
 * Points the template's two forms at Laravel.
 *
 * Webflow's runtime only hijacks a form that has no `action`, so giving each one
 * an action and a POST method hands submission back to the browser. The inputs
 * keep their original names; FormController maps them.
 *
 * Run: php tools/wire_forms.php
 */

$ROOT = dirname(__DIR__) . '/resources/views/site/';

$FORMS = [
    [
        'file' => 'pages/contact.blade.php',
        'data_name' => 'Contact Us Form',
        'route' => 'contact.submit',
        'key' => 'contact',
        'repopulate' => ['First-name', 'Last-name', 'Email', 'Phone-number', 'Subject'],
        'textarea' => 'field',
    ],
    [
        'file' => 'partials/footer.blade.php',
        'data_name' => 'Subscription Email Form',
        'route' => 'subscribe',
        'key' => 'subscribe',
        'repopulate' => ['Email'],
        'textarea' => null,
    ],
    [
        /*
         * The apply form carries a CV, so it needs an enctype the other two do
         * not, and its action needs the job in the URL — $job is what
         * PageController@careerDetails passes to this view.
         */
        'file' => 'pages/career-details.blade.php',
        'data_name' => 'Job Application Form',
        'route' => 'career.apply',
        'route_args' => '$job->slug',
        'key' => 'apply',
        'repopulate' => ['Applicant-name', 'Applicant-email', 'Applicant-phone'],
        'textarea' => 'Applicant-note',
        'multipart' => true,
    ],
];

foreach ($FORMS as $form) {
    $file = $ROOT . $form['file'];
    $html = file_get_contents($file);
    $before = strlen($html);

    // ---------------------------------------------------------------- form tag
    $pattern = '#<form\b([^>]*data-name="' . preg_quote($form['data_name'], '#') . '"[^>]*)>#';
    if (! preg_match($pattern, $html, $m)) {
        echo "  ! form not found in {$form['file']}\n";
        continue;
    }

    $attrs = $m[1];
    $attrs = preg_replace('#\s+method="[^"]*"#i', '', $attrs);
    $attrs = preg_replace('#\s+action="[^"]*"#i', '', $attrs);
    $attrs = preg_replace('#\s+enctype="[^"]*"#i', '', $attrs);

    $route = "route('" . $form['route'] . "'"
        . (isset($form['route_args']) ? ', ' . $form['route_args'] : '')
        . ')';

    $attrs .= ' method="POST" action="{{ ' . $route . ' }}"';

    // a form carrying a file has to say so, or PHP receives no upload at all
    if ($form['multipart'] ?? false) {
        $attrs .= ' enctype="multipart/form-data"';
    }

    $html = str_replace($m[0], '<form' . $attrs . '>@csrf', $html);

    // ---------------------------------------------------------------- inputs
    foreach ($form['repopulate'] as $name) {
        $html = preg_replace_callback(
            '#<input\b([^>]*name="' . preg_quote($name, '#') . '"[^>]*)>#',
            function (array $mm) use ($name): string {
                $a = preg_replace('#\s+value="[^"]*"#', '', $mm[1]);

                return '<input' . $a . ' value="{{ old(\'' . $name . '\') }}">';
            },
            $html,
            1
        );
    }

    if ($form['textarea']) {
        $html = preg_replace(
            '#(<textarea\b[^>]*name="' . preg_quote($form['textarea'], '#') . '"[^>]*>)(.*?)(</textarea>)#s',
            '$1{{ old(\'' . $form['textarea'] . '\') }}$3',
            $html,
            1
        );
    }

    // ---------------------------------------------------------------- result blocks
    // Webflow hides these with CSS; an inline style reveals the right one.
    $sent = "@if (session('form_sent') === '{$form['key']}') style=\"display:block\" @endif";
    $failed = "@if (session('form_failed') === '{$form['key']}' || \$errors->{'{$form['key']}'}->any()) style=\"display:block\" @endif";

    $html = preg_replace(
        '#<div class="success-message w-form-done"#',
        '<div ' . $sent . ' class="success-message w-form-done"',
        $html,
        1
    );

    $html = preg_replace(
        '#<div class="error-message w-form-fail"#',
        '<div ' . $failed . ' class="error-message w-form-fail"',
        $html,
        1
    );


    file_put_contents($file, $html);
    printf("  %-32s wired (%d -> %d bytes)\n", $form['file'], $before, strlen($html));
}
