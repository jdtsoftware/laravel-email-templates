<?php
namespace JDT\LaravelEmailTemplates\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EmailTemplate
 * @package JDT\LaravelEmailTemplates\Entities
 */
class EmailTemplate extends Model
{
    use SoftDeletes;

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

    /**
     * The email layout associated with this template.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function layout()
    {
        return $this->hasOne(EmailLayout::class, 'id', 'layout_id');
    }
}
