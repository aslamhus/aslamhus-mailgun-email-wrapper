# Aslamhus\Email PHP Class

## Overview

A PHP package to simplify the Mailgun PHP API and make its methods conform to Sengrid API.

## Installation

```php
composer require aslamhus/mailgun-email-wrapper
```

## Usage

### Send basic email

```php

$email = new Email('your-sendgrid-api-key')
    ->setFrom('sender@example.com', 'Sender Name')
    ->addTo('recipient@example.com', 'Recipient Name')
    ->setSubject('Test email')
    ->addContent('text/plain', 'Hello world!')
    ->send();

```

### Send Email with dynamic template data

Dynamic template data variables can be set using `handlebars` {{my_var}}.
For more info see [https://docs.sendgrid.com/for-developers/sending-email/using-handlebars](https://docs.sendgrid.com/for-developers/sending-email/using-handlebars)

```php
$email = new Email('your-sendgrid-api-key')
    ->setFrom('sender@example.com', 'Sender Name')
    ->addTo('recipient@example.com', 'Recipient Name')
    ->setSubject('Test email')
    ->setTemplateId('your-template-id')
    ->addDynamicTemplateDatas([
        'subject' => 'My dynamic template email'
        'name' => '2020-01-01',
        'link' => 'https://www.example.com',
    ])
    ->send();
```

### Additional Features

- **Add Attachments:**

  ```php
  $email->addAttachment('path/to/file.pdf', 'application/pdf', 'document.pdf');
  ```

- **Add Content:**

  ```php
  $email->addContent('text/plain', 'This is the plain text content');
  $email->addContent('text/html', '<p>This is the HTML content</p>');
  ```

- **Get email response:**

  ```php
  // retrieve the response body, headers and status code after sending
  $response = $email->getResponse();

  ```

## Testing

To run tests on this library, follow these steps:

1. Set your sample.env file with the require fields, then rename sample.env to .env
2. Run tests

```php
composer run test
```

## License

This class is open-source and released under the [MIT License](LICENSE). Feel free to use, modify, and distribute it according to your project's needs.
