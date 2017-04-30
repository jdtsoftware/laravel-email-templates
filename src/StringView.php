<?php

namespace JDT\LaravelEmailTemplates;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use JDT\LaravelEmailTemplates\Helpers\CSS;
use JDT\LaravelEmailTemplates\Helpers\Bindings;
use JDT\LaravelEmailTemplates\Entities\EmailTemplate;

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
     * @var string
     */
    protected $stylesheet;

    /**
     * @var string
     */
    protected $html;

    /**
     * StringView constructor.
     * @param EmailTemplate $email
     * @param array $data
     * @param string|null $stylesheet
     */
    public function __construct(EmailTemplate $email, array $data = [], string $stylesheet = null, $html = false)
    {
        $this->email = $email;
        $this->data = $data;
        $this->stylesheet = $stylesheet;
        $this->html = $html;
    }

    /**
     * Get content as a string of HTML.  Falls back to text if HTML not requested.
     *
     * @return string
     */
    public function toHtml() : string
    {
        if ($this->html) {
            $emailLayout = $this->email->layout;

            if (!empty($emailLayout) && !empty($this->stylesheet)) {
                $emailLayout->layout = CSS::transform($emailLayout->layout, $this->stylesheet);
            }

            return !empty($emailLayout)
                ? str_replace('{{content}}', $this->render(), $emailLayout->layout)
                : $this->render();
        }

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

        return $bound;
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
