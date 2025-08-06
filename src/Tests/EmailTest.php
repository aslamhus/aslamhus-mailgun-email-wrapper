<?php

use PHPUnit\Framework\TestCase;
use Aslamhus\Email\Mailgun\Email;

const API_KEY = "YOUR_API_KEY";
const DOMAIN = 'YOUR_MAILGUN_DOMAIN';
const YOUR_EMAIL_ADDRESS = 'sample@emailcom';
const YOUR_NAME = 'Your Name';
const TEST_EMAIL_ADDRESS = "testrecipient@email.com";
const TEST_NAME = 'Test Recipient';

class EmailTest extends TestCase
{
    /**
     * Test send basic email
     *
     * This test will send an email to Sendgrid's test email address
     *
     * @return void
     */
    public function testSendBasicEmail()
    {
        $didSend = (new Email(API_KEY, DOMAIN))
        ->setFrom(YOUR_EMAIL_ADDRESS, YOUR_NAME)
        ->addTo(TEST_EMAIL_ADDRESS, TEST_NAME)
        ->addContent('text/plain', 'Hello, if you received this message your mail configuration is working. Thanks and Happy Emailing!')
        ->setSubject('[Test] Testing mailgun email wrapper')
        ->send();

        $this->assertTrue($didSend === true);
    }
}
