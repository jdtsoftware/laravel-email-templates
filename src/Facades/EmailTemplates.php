<?php

namespace JDT\LaravelEmailTemplates\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class EmailTemplates.
 */
class EmailTemplates extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() : string
    {
        return 'laravel-email-templates';
    }
}
