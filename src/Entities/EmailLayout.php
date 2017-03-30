<?php

namespace JDT\LaravelEmailTemplates\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EmailLayout.
 */
class EmailLayout extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'email_layout';

    /**
     * Fields for mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'layout',
    ];
}
