<?php

namespace JDT\LaravelEmailTemplates;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use JDT\LaravelEmailTemplates\Entities\EmailTemplate;

/**
 * Class TemplateMailable
 * @package JDT\LaravelEmailTemplates
 */
class TemplateMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var EmailTemplate
     */
    protected $email;

    /**
     * TemplateMailable constructor.
     * @param EmailTemplate $email
     * @param array $data
     */
    public function __construct(EmailTemplate $email, array $data = [])
    {
        $this->email = $email;
        $this->subject = $email->subject;
        $this->viewData = $data;
    }

    /**
     * @return array
     */
    public function build() : array
    {
        $this->view = ['html' => new StringView($this->email->content, $this->viewData)];
        return $this->view;
    }
}