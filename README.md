# Laravel Email Templates

Database driven email templates for >= Laravel 5.4 and PHP 7.

## Configuration

First register the service provider in config/app.php:

```php
'providers' => [
    # ...
    JDT\LaravelEmailTemplates\ServiceProvider::class,
],
```

Then, in the same file, add the facade to the aliases config:

```php
'aliases' => [
    # ...
    'EmailTemplate' => JDT\LaravelEmailTemplates\Facades\EmailTemplates::class,
]
```

Next, set up the database table that'll hold all of our email templates:

```sql
CREATE TABLE `email_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) unsigned DEFAULT NULL,
  `handle` varchar(128) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `language` varchar(4) NOT NULL DEFAULT 'en',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `handle` (`handle`),
  KEY `language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

## Usage

The package is built in such a way that it plays nicely with the existing Laravel Mailer functionality.

Given a template existing in the above table with the handle 'registration', email can be sent simply as below:

```php
$mail = \EmailTemplate::fetch('registration', ['name' => 'Jon']);
 
\Mail::to('foo@bar.com', $mail);
```

You can of course pass the language to translate the chosen email, providing you have created an email for that
handle/language combination.

```php
$mail = \EmailTemplate::fetch('registration', ['name' => 'Jon'], 'es');
 
\Mail::to('foo@bar.com', $mail);
```

This package doesn't rely on a templating engine such as Blade or Twig to handle any 
of the email messages, but does provide it's own view class adhering to Laravel contracts.

This means that you can pass data to the email just as you would any other view, without 
having to worry about the choice of templating package you use elsewhere in your project.

```php
$mail = \EmailTemplate::fetch('registration', ['first_name' => 'Jon']);
 
$mail->with('last_name', 'Braud');
 
$mail->with([
    'verify_url'=> 'https:/....',
    'signup_time' => \Carbon\Carbon::now()->toDateTimeString()
]);
 
\Mail::to('foo@bar.com', $mail);
```