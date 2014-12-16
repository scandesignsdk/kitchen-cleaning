<?php
namespace AppBundle\Service;

use AppBundle\Entity\Cleaning;
use AppBundle\Entity\Point;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class SmileyService
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

    public function sendSmileyMails(\DateTime $date)
    {
        $team = $this->manager->getRepository('AppBundle:Cleaning')->findTeam($date);
        $users = $this->manager->getRepository('AppBundle:User')->findUsers();

        foreach($users as $user) {
            if ($user->getId() !== $team->getUsedUser()->getId()) {
                $templateData = [
                    'team' => $team,
                    'user' => $user
                ];

                $template = $this->template->loadTemplate(':emails:smiley.email.twig');
                $subject = $template->renderBlock('subject', [
                    'date' => $date
                ]);
                $bodyHtml = $template->renderBlock('body_html', $templateData);
                $bodyTxt = $template->renderBlock('body_text', $templateData);

                $this->mailer
                    ->setSubject($subject)
                    ->setTo($user->getEmail(), $user->getName())
                    ->setBody($bodyTxt, $bodyHtml)
                    ->send()
                ;
            }
        }

    }

    /**
     * @param Cleaning $cleaning
     * @param User $user
     * @param int $points
     * @return bool
     * @throws \Exception
     */
    public function setPoints(Cleaning $cleaning, User $user, $points)
    {
        $point = $this->manager->getRepository('AppBundle:Point')
            ->findOneBy(array('user' => $user->getId(), 'cleaning' => $cleaning->getId()))
        ;

        if (! is_object($point)) {
            $point = new Point();
            $point
                ->setCleaning($cleaning)
                ->setPoint($points)
                ->setUser($user)
            ;

            $this->manager->persist($point);
            $this->manager->flush();
            return true;
        }

        throw new \Exception('You have already added voted');
    }

}
