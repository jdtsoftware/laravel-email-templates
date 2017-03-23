<?php
namespace JDT\LaravelEmailTemplates;

use JDT\LaravelEmailTemplates\Entities\EmailTemplate;

/**
 * Class EmailTemplateRepository
 * @package JDT\LaravelEmailTemplates
 */
class EmailTemplateRepository
{
    /**
     * @param $emailTemplateId
     * @return mixed
     */
    public function find($emailTemplateId) : EmailTemplate
    {
        return EmailTemplate::find($emailTemplateId);
    }

    /**
     * @param string $handle
     * @param string $language
     * @param string|null $fallbackLanguage
     * @return EmailTemplate
     */
    public function findByHandle(string $handle, string $language, string $fallbackLanguage = null) : EmailTemplate
    {
        $query = EmailTemplate::where('handle', $handle)
            ->where('language', $language);

        if (!empty($fallbackLanguage)) {
            $query->orWhere('language', $fallbackLanguage);
        }

        return $query->first();
    }
}