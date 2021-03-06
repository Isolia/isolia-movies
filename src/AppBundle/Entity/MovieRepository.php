<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MovieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MovieRepository extends EntityRepository
{
    public function findByYear($minYear, $maxYear){
        $query = $this->createQueryBuilder("m")
                ->select("m")
                ->andWhere("m.year >= :minYear")
                ->setParameter("minYear", $minYear)
                ->getQuery();
        $movies = $query->getResult();
    }
    
    public function countAll($minYear = 0){
        $queryBuilder= $this->createQueryBuilder("m")
                ->select("COUNT(m)");
        
        if (!empty($minYear)){
            $queryBuilder->andWhere("m.year>= :minYear");
            $queryBuilder->setParameter("minYear", $minYear);
        }
        
        $query = $queryBuilder->getQuery();
        $count = $query->getSingleScalarResult();
        return $count;
    }
}