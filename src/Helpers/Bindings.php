<?php

namespace JDT\LaravelEmailTemplates\Helpers;

/**
 * Class Bindings.
 */
class Bindings
{
    /**
     * Treat template variables passed in to wrap replacement keys in the configured
     * anchors, ready to be replaced with the placeholder bindings in the content.
     * E.g.
     *     first_name => {{first_name}} (default anchors).
     *
     * @param $data
     * @return array
     */
    public static function normaliseKeys(array $data) : array
    {
        $open = preg_quote(config('laravel-email-templates.bindingAnchors.open', '{{'));
        $close = preg_quote(config('laravel-email-templates.bindingAnchors.open', '}}'));
        $result = [];

        foreach ($data as $key => $val) {
            $pattern = '/' . $open . '.+' . $close . '/';

            if (($ret = preg_match($pattern, $key)) === false) {
                throw new \RuntimeException("Invalid pattern '{$pattern} with current email anchor configuration");
            } elseif ($ret === 0) {
                $key = '{{' . trim($key) . '}}';
            }

            $result[$key] = $val;
        }

        return $result;
    }
}
