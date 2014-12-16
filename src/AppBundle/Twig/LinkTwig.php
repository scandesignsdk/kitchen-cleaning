<?php
namespace AppBundle\Twig;

use AppBundle\Entity\Cleaning;
use AppBundle\Entity\User;
use AppBundle\Service\TokenService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Templating\Helper\CoreAssetsHelper;

class LinkTwig extends \Twig_Extension
{

    /**
     * @var TokenService
     */
    private $token;

    /**
     * @var UrlGeneratorInterface
     */
    private $generator;

    public function __construct(TokenService $token, UrlGeneratorInterface $generator)
    {
        $this->token = $token;
        $this->generator = $generator;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('smileylink', [$this, 'generateSmileyLink']),
            new \Twig_SimpleFunction('backuplink', [$this, 'generateBackupLink']),
        ];
    }

    /**
     * @param Cleaning $cleaning
     * @param User $user
     * @param int $points
     * @return string
     */
    public function generateSmileyLink(Cleaning $cleaning, User $user, $points)
    {
        return $this->generator->generate('smiley', [
            'id' => $cleaning->getId(),
            'user' => $user->getId(),
            'points' => $points,
            'token' => $this->token->generateSmileyToken($user, $points, $cleaning)
        ], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * @param Cleaning $cleaning
     * @param User $user
     * @return string
     */
    public function generateBackupLink(Cleaning $cleaning)
    {
        return $this->generator->generate('backup', [
            'id' => $cleaning->getId(),
            'user' => $cleaning->getBackup()->getId(),
            'token' => $this->token->generateBackupToken($cleaning->getBackup(), $cleaning)
        ], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'app.link';
    }
}
