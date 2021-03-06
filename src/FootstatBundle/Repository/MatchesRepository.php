<?php

namespace FootstatBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MatchesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MatchesRepository extends EntityRepository
{
    public function byChampionnat($championnat){
        $db = $this->createQueryBuilder('u')
                ->select('u')
                ->where('u.championnat = :championnat')
                ->orderBy('u.id')
                ->setParameter('championnat', $championnat)
                ->orderBy('u.date', 'ASC')
                ->setMaxResults(10);
        return $db->getQuery()->getResult();                
    }
    
    public function byDate(){
        $today = new \DateTime();
        $db = $this->createQueryBuilder('u')
                ->select('u')
                ->andWhere('u.date > :date_start')
                ->andWhere('u.date < :date_end')
                ->andWhere('u.type = 1')
                ->orderBy('u.date')
                ->setParameter('date_start', $today->format('Y-m-d 00:00:00'))
                ->setParameter('date_end',   $today->format('Y-m-d 23:59:59'));

        return $db->getQuery()->getResult();
                
    }
    public function allNextmatch(){
        $now = date('Y-m-d').' 00:00:00';
        $db = $this->createQueryBuilder('u')
                ->select('u')
                ->andWhere('u.date >= :now' )
                ->andWhere('u.type = 1')
                ->orderBy('u.date')
                ->setMaxResults(50)
                ->setParameter('now', $now);
        return $db->getQuery()->getResult();            
    }
   
    public function byExpired(){
        $now = date('Y-m-d').' 00:00:00';
        $db = $this->createQueryBuilder('u')
                ->select('u')
                ->Where('u.date < :now' )
                ->andWhere('u.type = 1')
                ->orderBy('u.date')
                ->setParameter('now', $now);
        return $db->getQuery()->getResult();
                
    }
    
     public function byNextmChamp($championnat){
        $now = date('Y-m-d').' 00:00:00';
        $db = $this->createQueryBuilder('u')
                ->select('u')
                ->andWhere('u.championnat = :championnat')
                ->andWhere('u.date >= :now' )
                ->andWhere('u.type = 1')
                ->orderBy('u.date')
                ->setParameter('championnat', $championnat)
                ->setParameter('now', $now)
                ->setMaxResults( 15 );
        return $db->getQuery()->getResult();
                
    }
}
