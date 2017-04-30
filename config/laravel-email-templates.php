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

    // Whether to cache email templates
    'cache' => true,

    // Duration in minutes
    'cacheDuration' => 60,

    // Format for cache keys, replaced items are: handle, language, ownerId
    'cacheKeyFormat' => 'email_template_%s_%s_%d'
];
