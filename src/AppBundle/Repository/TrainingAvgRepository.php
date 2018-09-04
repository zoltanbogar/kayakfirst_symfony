<?php namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class TrainingAvgRepository extends EntityRepository
{
    public function findBySessionIdRange($from,$to,$user, $hydrate = Query::HYDRATE_OBJECT){
        $qb = $this->createQueryBuilder('t')
            ->distinct()
            ->select('t')
            ->where('t.sessionId >= :from')
            ->andWhere('t.sessionId <= :to')
            ->andWhere('t.user = :user')
            ->setParameter(':from', $from)
            ->setParameter(':to', $to)
            ->setParameter(':user', $user)
            ->addOrderBy('t.sessionId');

        return $qb->getQuery()->getResult($hydrate);
    }
    public function findBySessionIdsAndUser($list, $user) {
        $qb = $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.sessionId in (:list)')
            ->andWhere('t.user = :user')
            ->setParameter(':list', $list)
            ->setParameter(':user', $user);

        return $qb->getQuery()->getResult();
    }
}