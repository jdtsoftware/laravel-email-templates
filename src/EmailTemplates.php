<?php
namespace JDT\LaravelEmailTemplates;

/**
 * Class EmailTemplates
 * @package JDT\LaravelEmailTemplates
 */
class EmailTemplates
{
    /**
     * @var EmailTemplateRepository
     */
    protected $repository;

    /**
     * EmailTemplates constructor.
     */
	public function __construct(EmailTemplateRepository $emailTemplateRepository)
	{
	    $this->repository = $emailTemplateRepository;
	}

    /**
     * @param $template
     * @param array $data
     * @param string $language
     * @return TemplateMailable|null
     * @throws \Exception
     */
	public function fetch(string $template, array $data = [], string $language = null) : TemplateMailable
	{
		# If a language wasn't passed then we check if we have a default
		# language to fall back to.  If we have neither, don't continue.
		if (empty($language)) {
			$language = config('laravel-email-templates.defaultLanguage');

			if (empty($language)) {
			    throw new \Exception(
			        "No language passed to fetch().  Either pass a language or set the defaultLanguage config item."
                );
            }
		}

		$entity = $this->repository->findByHandle(
		    $template,
            $language,
            config('laravel-email-templates.defaultLanguageFallback')
        );

		if (empty($entity)) {
		    return null;
        }

		return new TemplateMailable($entity, $data);
	}
}