<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\AbstractFixture;
use AppBundle\Entity\Cleaning;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCleaningData extends AbstractFixture
{

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < $this->getNumberCleaning(); $i++) {
            $primary = $this->getRandomUser();
            $backup = $this->getRandomUser($primary->getId());
            $usebackup = $this->getFaker()->boolean();
            if ($usebackup) {
                $backup->addCleaning();
                $manager->persist($backup);
            } else {
                $primary->addCleaning();
                $manager->persist($primary);
            }

            $cleaning = new Cleaning();
            $cleaning
                ->setDate($this->getCleaningDate($i))
                ->setUser($primary)
                ->setBackup($backup)
                ->setUseBackup($usebackup)
            ;
            $this->addReference('cleaning-' . $i, $cleaning);
            $manager->persist($cleaning);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 20;
    }

}
