<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{

    /**
     * @return User[]
     */
    public function findUsers()
    {
        return $this->findAll();
    }

    /**
     * @return User[]
     */
    public function findTimeToCleanUsers()
    {
        $query = $this->createQueryBuilder('user');
        $query->orderBy('user.cleaningnumbers', 'desc');

        /** @var User[] $users */
        $users = $query->getQuery()->getResult();
        usort($users, function(User $a, User $b) {
            if ($a->getCleaningnumbers() === $b->getCleaningnumbers()) {
                return 0;
            }
            return ($a->getCleaningnumbers() > $b->getCleaningnumbers() ? 1 : -1);
        });
        return $users;
    }

}