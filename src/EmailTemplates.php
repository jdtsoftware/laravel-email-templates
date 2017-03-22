<?php
namespace JDT\LaravelEmailTemplates;

class EmailTemplates
{
	public function __construct()
	{
	}

	/**
	 * [fetch description]
	 * @param  [type] $template [description]
	 * @param  [type] $language [description]
	 * @return [type]           [description]
	 */
	public function fetch($template, $language = null)
	{
		return view('laravel-email-templates::root', ['content' => 'test']);
	}
}