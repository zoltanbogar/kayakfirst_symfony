<?php

namespace AppBundle\Repository;

/**
 * NewTrainingRepository
 */
class NewTrainingRepository extends \Doctrine\ORM\EntityRepository
{
    public function findBySessionIds($list, $user) {
        $qb = $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.sessionId in (:list)')
            ->andWhere('t.userId = :user')
            ->setParameter(':list', $list)
            ->setParameter(':user', $user)
            ->addOrderBy('t.sessionId')
            ->addOrderBy('t.timestamp');

        return $qb->getQuery()->getResult();
    }
}
