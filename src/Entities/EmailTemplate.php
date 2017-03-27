<?php
namespace JDT\LaravelEmailTemplates\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailTemplate
 * @package JDT\LaravelEmailTemplates\Entities
 */
class EmailTemplate extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'email_template';

    /**
     * Fields for mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'handle',
        'subject',
        'content',
        'language'
    ];
}
