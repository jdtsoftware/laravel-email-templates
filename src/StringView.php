<?php

namespace JDT\LaravelEmailTemplates;

use Illuminate\Contracts\View\View;
use JDT\LaravelEmailTemplates\Entities\EmailTemplate;
use Illuminate\Contracts\Support\Htmlable;
use JDT\LaravelEmailTemplates\Helpers\Bindings;

/**
 * Class StringView.
 */
class StringView implements Htmlable, View
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $data;

    /**
     * StringView constructor.
     * @param EmailTemplate $email
     * @param array $data
     */
    public function __construct(EmailTemplate $email, array $data = [])
    {
        $this->email = $email;
        $this->data = $data;
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml() : string
    {
        return $this->render();
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render() : string
    {
        $treated = Bindings::normaliseKeys($this->data);

        $bound = str_replace(
            array_keys($treated),
            array_values($treated),
            $this->email->content
        );

        $emailLayout = $this->email->layout;
        return (!empty($emailLayout) ? str_replace('{{content}}', $bound, $emailLayout->layout) : $bound);
    }

    /**
     * Get the name of the view.
     *
     * @return string
     */
    public function name() : string
    {
        return 'laravel-email-templates';
    }

    /**
     * @param array|string $key
     * @param null $value
     * @return StringView
     */
    public function with($key, $value = null) : StringView
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }
}
