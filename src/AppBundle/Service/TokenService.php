<?php
namespace AppBundle\Service;

use AppBundle\Entity\Cleaning;
use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface;

class TokenService
{

    /**
     * @var CsrfProviderInterface
     */
    private $interface;

    /**
     * @var string
     */
    private $secret;

    public function __construct(CsrfProviderInterface $interface, $secret)
    {
        $this->interface = $interface;
        $this->secret = $secret;
    }

    /**
     * @param string $token
     * @param string $intention
     * @param array $parameters
     * @return bool
     */
    public function validateToken($token, $intention, array $parameters = array())
    {
        return $token === $this->generateToken($intention, $parameters);
    }

    /**
     * @param string $intention
     * @param array $parameters
     * @return string
     */
    public function generateToken($intention, array $parameters = array())
    {
        return md5($this->secret . $intention . join('', $parameters));
    }

    /**
     * @param User $user
     * @param $points
     * @param Cleaning $cleaning
     * @return string
     */
    public function generateSmileyToken(User $user, $points, Cleaning $cleaning)
    {
        return $this->generateToken('smiley', $this->smileyTokenData($user, $points, $cleaning));
    }

    /**
     * @param $token
     * @param User $user
     * @param $points
     * @param Cleaning $cleaning
     * @return bool
     */
    public function validateSmileyToken($token, User $user, $points, Cleaning $cleaning)
    {
        return $this->validateToken($token, 'smiley', $this->smileyTokenData($user, $points, $cleaning));
    }

    /**
     * @param User $user
     * @param Cleaning $cleaning
     * @return string
     */
    public function generateBackupToken(User $user, Cleaning $cleaning)
    {
        return $this->generateToken('usebackup', $this->backupTokenData($user, $cleaning));
    }

    /**
     * @param $token
     * @param User $user
     * @param Cleaning $cleaning
     * @return bool
     */
    public function validateBackupToken($token, User $user, Cleaning $cleaning)
    {
        return $this->validateToken($token, 'usebackup', $this->backupTokenData($user, $cleaning));
    }

    private function backupTokenData(User $user, Cleaning $cleaning)
    {
        return [
            'user' => $user->getId(),
            'cleaning' => $cleaning->getId()
        ];
    }

    private function smileyTokenData(User $user, $points, Cleaning $cleaning)
    {
        return [
            'user' => $user->getId(),
            'points' => $points,
            'cleaning' => $cleaning->getId()
        ];
    }

}
