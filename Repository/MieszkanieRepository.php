<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * MieszkanieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MieszkanieRepository extends EntityRepository
{
    /**
     * @param array $szukaj
     * @return Query
     */
    public function pobierzWszystko(array $szukaj = []): Query
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('m', 'n')
            ->from('Entity\Mieszkanie', 'm')
            ->join('m.nieruchomosc', 'n');

        if (!empty($szukaj['typ_oferty'])) {
            $qb->andWhere('n.typ_oferty = :typ_oferty');
            $qb->setParameter('typ_oferty', $szukaj['typ_oferty']);
        }
        if (!empty($szukaj['miasto'])) {
            $qb->andWhere('n.miasto = :miasto');
            $qb->setParameter('miasto', $szukaj['miasto']);
        }

        if (!empty($szukaj['powierzchnia_od'])) {
            $qb->andWhere('n.powierzchnia >= :powierzchnia_od');
            $qb->setParameter('powierzchnia_od', $szukaj['powierzchnia_od']);
        }

        if (!empty($szukaj['powierzchnia_do'])) {
            $qb->andWhere('n.powierzchnia <= :powierzchnia_do');
            $qb->setParameter('powierzchnia_do', $szukaj['powierzchnia_do']);
        }

        if (!empty($szukaj['cena_od'])) {
            $qb->andWhere('n.cena >= :cena_od');
            $qb->setParameter('cena_od', $szukaj['cena_od']);
        }

        if (!empty($szukaj['cena_do'])) {
            $qb->andWhere('n.cena <= :cena_do');
            $qb->setParameter('cena_do', $szukaj['cena_do']);
        }
        if (!empty($szukaj['rok_budowy'])) {
            $qb->andWhere('m.rok_budowy = :rok_budowy');
            $qb->setParameter('rok_budowy', $szukaj['rok_budowy']);
        }

        return $qb->getQuery();
    }
}
