<?php

namespace JDT\LaravelEmailTemplates;

use Illuminate\Contracts\Cache\Repository;

/**
 * Class EmailTemplates.
 */
class EmailTemplates
{
    /**
     * @var EmailTemplateRepository
     */
    protected $repository;

    /**
     * @var Repository
     */
    protected $cache;

    /**
     * @var string
     */
    protected $stylesheet;

    /**
     * EmailTemplates constructor.
     * @param EmailTemplateRepository $emailTemplateRepository
     * @param Repository $cache
     */
    public function __construct(
        EmailTemplateRepository $emailTemplateRepository,
        Repository $cache,
        string $stylesheet = null
    ) {
        $this->repository = $emailTemplateRepository;
        $this->cache = $cache;
        $this->stylesheet = $stylesheet;
    }

    /**
     * @param string $handle
     * @param array $data
     * @param string|null $language
     * @param null $ownerId
     * @return TemplateMailable
     * @throws \Exception
     */
    public function fetch(string $handle, array $data = [], string $language = null, $ownerId = null):TemplateMailable
    {
        // If a language wasn't passed then we check if we have a default
        // language to fall back to.  If we have neither, don't continue.
        if (empty($language)) {
            $language = config('laravel-email-templates.defaultLanguage');

            if (empty($language)) {
                throw new \Exception(
                    'No language passed to fetch().  Either pass a language or set the defaultLanguage config item.'
                );
            }
        }

        $entity = null;
        $caching = config('laravel-email-templates.cache');
        if ($caching && false) {
            $entity = $this->cache->get($this->getCacheKey($handle, $language, $ownerId));
        }

        if (empty($entity)) {
            $entity = $this->repository->findByHandle(
                $handle,
                $language,
                config('laravel-email-templates.defaultLanguageFallback'),
                $ownerId
            );
        }

        if (empty($entity)) {
            return null;
        }

        if ($caching) {
            $this->cache->put(
                $this->getCacheKey($handle, $language, $ownerId),
                $entity,
                config('laravel-email-templates.cacheDuration')
            );
        }

        return new TemplateMailable($entity, $data, $this->stylesheet);
    }

    /**
     * Generate the cache key for the given template data.
     *
     * @param $handle
     * @param $language
     * @param $ownerId
     * @return string
     */
    protected function getCacheKey($handle, $language, $ownerId)
    {
        return sprintf(config('laravel-email-templates.cacheKeyFormat'), $handle, $language, $ownerId);
    }
}
