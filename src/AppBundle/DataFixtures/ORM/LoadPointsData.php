<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\AbstractFixture;
use AppBundle\Entity\Point;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPointsData extends AbstractFixture
{

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < $this->getNumberPoints(); $i++) {
            $point = new Point();
            $point->setUser($this->getRandomUser())
                ->setCleaning($this->getRandomCleaning())
                ->setPoint($this->getRandomPoint())
            ;
            $manager->persist($point);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 30;
    }

}
