<?php
namespace JDT\LaravelEmailTemplates;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

/**
 * Class StringView
 * @package JDT\LaravelEmailTemplates
 */
class StringView implements Htmlable, View
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $data;

    /**
     * StringView constructor.
     * @param string $content
     * @param array $data
     */
    public function __construct($content, array $data = [])
    {
        $this->content = $content;
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
        return str_replace(
            $this->normaliseDataKeys($this->data),
            array_values($this->data),
            $this->content
        );
    }

    /**
     * @param array $data
     * @return array
     */
    protected function normaliseDataKeys(array $data = []) : array
    {
        $result = [];

        foreach ($data as $key => $val) {
            if (!preg_match('/\{\{\$.+\}\}/', $key)) {
                $key = "{{" . trim($key) . "}}";
            }

            $result[] = $key;
        }

        return $result;
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