<?php

namespace Aslamhus\Email\Mailgun;

use Mailgun\Mailgun;
use Mailgun\Message\MessageBuilder;
use Mailgun\Model\Message\SendResponse;

/**
 *  // Define the from address.
 *  $this->builder->setFromAddress(ADMIN_EMAIL_ADDRESS, ['first' => 'John', 'last' => 'Cobley']);
 *  // Define a to recipient.
 *  $this->addToRecipient($toEmail, ['full_name' => $toName]);
 *  $builder->addCcRecipient('sally.doe@example.com', ['full_name' => 'Sally Doe']);
 *  $this->setSubject($subject);
 *   Define the body of the message (One is required).
 *  $this->setTextBody($plainTextMessage);
 * $this->setHtmlBody($htmlMessage);
 *  $builder->setTemplate('template_name');
 * Other Optional Parameters.
 * $builder->addCampaignId('My-Awesome-Campaign');
 * $builder->addCustomHeader('Customer-Id', '12345');
 *  $builder->addAttachment('@/tron.jpg');
 * $builder->setDeliveryTime('tomorrow 8:00AM', 'PST');
 * $builder->setClickTracking(true);
 * Finally, send the message.
 */
class Email
{
    private Mailgun $mg;
    public MessageBuilder $builder;
    private string $domain;
    public SendResponse $response;

    /**
     * Constructor
     *
     * @param [type] $apiKey - mailgun api key
     * @param [type] $domain - the mailgun authenticated domain
     */
    public function __construct($apiKey, $domain)
    {

        $this->mg = Mailgun::create($apiKey); // For US servers
        $this->domain = $domain;
        $this->builder = new MessageBuilder();
    }

    public function addTo(string $address, string $name): Email
    {
        $this->builder->addToRecipient($address, ['full_name' => $name]);
        return $this;
    }


    public function setFrom(string $address, string $name): Email
    {
        $this->builder->setFromAddress($address, ['full_name' => $name]);
        return $this;
    }

    public function setSubject(string $subject): Email
    {
        $this->builder->setSubject($subject);
        return $this;
    }

    public function setReplyTo(string $address, string $name): Email
    {
        $this->builder->setReplyToAddress($address, ['full_name' => $name]);
        return $this;
    }

    /**
     * Add html/plain text content
     *
     * @param string $type - text/html or text/plain
     * @param [type] $value
     */
    public function addContent(string $type, $value = null)
    {
        switch ($type) {
            case 'text/plain':
                $this->builder->setTextBody($value);
                break;
            case 'text/html':

                $this->builder->setHtmlBody($value);
                break;

            default:
                throw new \Exception('Invalid email mime type, must be text/plain or text/html. Found: '.$type);

        }
        return $this;

    }

    public function addAttachment(string $contents, string $mimeType, string $filename): self
    {

        $this->builder->addStringAttachment($contents, $filename);
        return $this;
    }

    public function setTemplateId(string $template): self
    {
        $this->builder->setTemplate($template);
        return $this;
    }

    public function addDynamicTemplateDatas(array $data): self
    {
        $this->builder->addCustomHeader('X-Mailgun-Variables', json_encode($data));
        return $this;
    }


    public function getResponse(): SendResponse
    {
        return $this->response;
        // $response =  new \stdClass();
        // $response->statusCode = function () {
        //     return '';
        // };
        // return $response;
    }

    public function getStatusCode()
    {
        return $this->response?->getStatusCode();
    }



    public function send(): bool
    {

        try {
            $this->response =  $this->mg->messages()->send($this->domain, $this->builder->getMessage());

        } catch (\Exception $e) {
            throw new \Exception('Failed to send email: ' . $e->getMessage());
        }
        return $this->response->getStatusCode() == 200;

    }

}
