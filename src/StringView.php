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
            $layout = '';

            if (!empty($emailLayout)) {
                $layout = $emailLayout->getOriginal()['layout'];
            }

            $content = !empty($layout)
                ? str_replace('{{content}}', $this->render(), $layout)
                : $this->render();

            if (!empty($this->stylesheet)) {
                return CSS::transform($this->translateBindings($content), $this->stylesheet);
            }

            return $this->translateBindings($content);
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
        return $this->translateBindings($this->email->content);
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

    /**
     * @param string $target
     * @return string
     */
    protected function translateBindings(string $target):string
    {
        $treated = Bindings::normaliseKeys($this->data);

        return str_replace(
            array_keys($treated),
            array_values($treated),
            $target
        );
    }
}
