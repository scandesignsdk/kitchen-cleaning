<?php
namespace AppBundle\Service;

class MailsenderService
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Swift_Message
     */
    private $message;

    /**
     * @var string
     */
    private $defaultFromEmail;
    /**
     * @var string
     */
    private $defaultFromName;

    public function __construct(\Swift_Mailer $mailer, $defaultFromEmail, $defaultFromName = null)
    {
        $this->mailer = $mailer;
        $this->message = \Swift_Message::newInstance();
        $this->defaultFromEmail = $defaultFromEmail;
        $this->defaultFromName = $defaultFromName;
    }

    /**
     * @param string $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->message->setSubject($subject);
        return $this;
    }

    /**
     * @param string $email
     * @param string|null $name
     * @return $this
     */
    public function setFrom($email, $name = null)
    {
        $this->message->setFrom($email, $name);
        return $this;
    }

    /**
     * @param string $email
     * @param string|null $name
     * @return $this
     */
    public function setTo($email, $name = null)
    {
        $this->message->setTo($email, $name);
        return $this;
    }

    /**
     * @param string$text
     * @param string|null $html
     * @return $this
     */
    public function setBody($text, $html = null)
    {
        $this->message->setBody($text, 'text/plain');
        if ($html) {
            $this->message->addPart($html, 'text/html');
        }
        return $this;
    }

    /**
     * @return int
     */
    public function send()
    {
        if (! $this->message->getFrom()) {
            $this->setFrom($this->defaultFromEmail, $this->defaultFromName);
        }

        return $this->mailer->send($this->message);
    }

}
