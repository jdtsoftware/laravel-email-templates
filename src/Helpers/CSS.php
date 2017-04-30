<?php

namespace JDT\LaravelEmailTemplates\Helpers;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

/**
 * Class CSS
 * @package JDT\LaravelEmailTemplates\Helpers
 */
class CSS
{
    /**
     * @param string $content
     * @param string $stylesheet
     * @return string
     */
    public static function transform(string $content, string $stylesheet)
    {
        $cssToInline = new CssToInlineStyles();

        if (($css = file_get_contents($stylesheet)) !== null) {
            return $cssToInline->convert($content, $css);
        }

        return $content;
    }
}
