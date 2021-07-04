<?php

namespace Repository;

/**
 * GruntRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GruntRepository extends \Doctrine\ORM\EntityRepository
{
    public function pobierzWszystko()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('g')
            ->from('Entity\Grunt', 'g')
            ->join('g.nieruchomosc', 'n');
        return $qb->getQuery()->getResult();
    }
}