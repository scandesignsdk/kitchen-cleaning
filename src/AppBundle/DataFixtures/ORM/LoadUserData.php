<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\AbstractFixture;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture
{

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < $this->getNumberUsers(); $i++) {
            $user = new User();
            $user->setEmail($this->getFaker()->email);
            $user->setName($this->getFaker()->name);
            $manager->persist($user);
            $this->addReference('user-' . $i, $user);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}
