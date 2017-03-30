<?php

return [
    // Default language for all template loading if not passed
    'defaultLanguage' => 'en',

    // Whether to fall back to the default language if your requested template
    // does not exist in your chosen language (other than default)
    'defaultLanguageFallback' => true,

    // Variable binding anchors.  The default style is {{var}} but these can be changed
    // if you have reason to do so.
    'bindingAnchors' => [
        'open' => '{{',
        'close' => '}}',
    ],
];
