<?php
namespace AppBundle\Service;

use AppBundle\Entity\Cleaning;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class TeamService
{

    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @var \Twig_Environment
     */
    private $template;

    /**
     * @var MailsenderService
     */
    private $mailer;

    /**
     * @var TokenService
     */
    private $token;

    public function __construct(EntityManager $manager, \Twig_Environment $template, MailsenderService $mailer, TokenService $token)
    {
        $this->manager = $manager;
        $this->template = $template;
        $this->mailer = $mailer;
        $this->token = $token;
    }

    /**
     * @param \DateTime $date
     * @return Cleaning
     */
    public function sendMailToTeam(\DateTime $date)
    {
        $team = $this->manager->getRepository('AppBundle:Cleaning')->findTeam($date, true);
        $this->generateBackupEmail($date, $team);
        $this->generatePrimaryEmail($date, $team);
    }

    public function addUser($name, $email)
    {
        $user = new User();
        $user
            ->setName($name)
            ->setEmail($email)
        ;
        $this->manager->persist($user);
        $this->manager->flush();
        return true;
    }

    private function generatePrimaryEmail(\DateTime $date, Cleaning $cleaning)
    {
        $parameters = [
            'team' => $cleaning
        ];

        $template = $this->template->loadTemplate(':emails:primary.email.twig');
        $subject = $template->renderBlock('subject', ['date' => $date]);
        $bodyHtml = $template->renderBlock('body_html', $parameters);
        $bodyTxt = $template->renderBlock('body_text', $parameters);
        $this->mailer
            ->setSubject($subject)
            ->setTo($cleaning->getBackup()->getEmail(), $cleaning->getBackup()->getName())
            ->setBody($bodyTxt, $bodyHtml)
            ->send()
        ;
    }

    private function generateBackupEmail(\DateTime $date, Cleaning $cleaning)
    {
        $parameters = [
            'team' => $cleaning,
        ];

        $template = $this->template->loadTemplate(':emails:backup.email.twig');
        $subject = $template->renderBlock('subject', ['date' => $date]);
        $bodyHtml = $template->renderBlock('body_html', $parameters);
        $bodyTxt = $template->renderBlock('body_text', $parameters);
        $this->mailer
            ->setSubject($subject)
            ->setTo($cleaning->getBackup()->getEmail(), $cleaning->getBackup()->getName())
            ->setBody($bodyTxt, $bodyHtml)
            ->send()
        ;
    }

    public function setBackupUser(User $user, Cleaning $cleaning)
    {
        if ($cleaning->getBackup()->getId() !== $user->getId()) {
            throw new \Exception('Where did you get this link from...');
        }

        if ($cleaning->getUseBackup() !== false) {
            throw new \Exception('You have already clicked this link');
        }

        $cleaning->setUseBackup(true);
        $primary = $cleaning->getUser();
        $primary->removeCleaning();

        $backup = $cleaning->getBackup();
        $backup->addCleaning();

        $this->manager->persist($backup);
        $this->manager->persist($primary);
        $this->manager->persist($cleaning);
        $this->manager->flush();
        return true;
    }


}
