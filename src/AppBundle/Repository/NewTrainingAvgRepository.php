<?php

namespace AppBundle\Repository;

/**
 * NewTrainingAvgRepository
 */
class NewTrainingAvgRepository extends \Doctrine\ORM\EntityRepository
{
    public function findBySessionIds($list, $userId) {
        $qb = $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.sessionId in (:list)')
            ->andWhere('t.userId = :userId')
            ->setParameter(':list', $list)
            ->setParameter(':userId', $userId);

        return $qb->getQuery()->getResult();
    }
    public function findBySessionIdRange($from, $to, $userId, $hydrate = Query::HYDRATE_OBJECT) {
        $qb = $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.sessionId >= :from')
            ->andWhere('t.sessionId <= :to')
            ->andWhere('t.userId = :userId')
            ->setParameter(':from', $from)
            ->setParameter(':to', $to)
            ->setParameter(':userId', $userId)
            ->addOrderBy('t.sessionId');

        return $qb->getQuery()->getResult($hydrate);
    }
}
