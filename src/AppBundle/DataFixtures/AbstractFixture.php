<?php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\Cleaning;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture as BaseAbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;

abstract class AbstractFixture extends BaseAbstractFixture implements OrderedFixtureInterface
{

    /**
     * @return \Faker\Generator
     */
    protected function getFaker()
    {
        return Factory::create();
    }

    /**
     * @return int
     */
    protected function getNumberUsers()
    {
        return 5;
    }

    /**
     * @param int|array $userids
     * @return User
     */
    protected function getRandomUser($userids = array())
    {
        if (! is_array($userids)) {
            $userids = array($userids);
        }

        while(true) {
            /** @var User $user */
            $user = $this->getReference('user-' . $this->getFaker()->numberBetween(0, ($this->getNumberUsers() - 1)));
            if (!in_array($user->getId(), $userids)) {
                return $user;
            }
        }

        return false;
    }

    /**
     * @return Cleaning
     */
    protected function getRandomCleaning()
    {
        return $this->getReference('cleaning-' . $this->getFaker()->numberBetween(0, ($this->getNumberCleaning() - 1)));
    }

    /**
     * @return int
     */
    protected function getNumberCleaning()
    {
        return 100;
    }

    /**
     * @param int $number
     * @return \DateTime
     */
    protected function getCleaningDate($number)
    {
        $n = $this->getNumberCleaning() / 2;
        $method = '';
        $days = 0;
        if ($n > $number) {
            $days = $n - $number;
            $method = 'sub';
        }

        if ($n < $number) {
            $days = $number - $n;
            $method = 'add';
        }

        if ($method) {
            return date_create()->$method(new \DateInterval('P' . $days . 'D'));
        }

        return new \DateTime();

    }

    /**
     * @return int
     */
    protected function getNumberPoints()
    {
        return 500;
    }

    /**
     * @return int
     */
    protected function getRandomPoint()
    {
        return 4;
        return $this->getFaker()->numberBetween(1, 4);
    }

}
