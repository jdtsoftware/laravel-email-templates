<?php

namespace JDT\LaravelEmailTemplates;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use JDT\LaravelEmailTemplates\Helpers\Bindings;
use JDT\LaravelEmailTemplates\Entities\EmailTemplate;

/**
 * Class TemplateMailable.
 */
class TemplateMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var EmailTemplate
     */
    protected $email;

    /**
     * @var string
     */
    protected $stylesheet;

    /**
     * TemplateMailable constructor.
     * @param EmailTemplate $email
     * @param array $data
     * @param string|null $stylesheet
     */
    public function __construct(EmailTemplate $email, array $data = [], string $stylesheet = null)
    {
        $this->email = $email;
        $this->subject = $email->subject;
        $this->viewData = $data + ['subject' => $this->subject];
        $this->stylesheet = $stylesheet;
    }

    /**
     * @return array
     */
    public function build() : array
    {
        $this->view = [
            'html' => new StringView($this->email, $this->viewData, $this->stylesheet, true),
            'text' => new StringView($this->email, $this->viewData, $this->stylesheet)
        ];

        return $this->view;
    }

    /**
     * Apply the view data to the subject of the email.
     *
     * @param \Illuminate\Mail\Message $message
     * @return $this
     */
    protected function buildSubject($message)
    {
        $bindings = Bindings::normaliseKeys($this->viewData);

        $bound = str_replace(
            array_keys($bindings),
            array_values($bindings),
            $this->email->subject
        );

        $message->subject($bound);

        return $this;
    }
}
