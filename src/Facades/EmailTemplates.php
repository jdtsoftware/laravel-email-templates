<?php
namespace JDT\LaravelEmailTemplates\Facades;

use Illuminate\Support\Facades\Facade;

class EmailTemplates extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-email-templates';
    }
}