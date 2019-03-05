<?php

namespace App\Repository;

use App\Entity\Rate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Rate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rate[]    findAll()
 * @method Rate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RateRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Rate::class);
    }

    /**
     * @return Rate[] Returns an array of Rate objects
     */
    public function findUsd()
    {
        return $this->createQueryBuilder('r')
            ->select('r.date, r.value')
            ->andWhere('r.name = :name')
            ->setParameter('name', 'usd-rub')
            ->orderBy('r.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Rate[] Returns an array of Rate objects
     */
    public function findEur()
    {
        return $this->createQueryBuilder('r')
            ->select('r.date, r.value')
            ->andWhere('r.name = :name')
            ->setParameter('name', 'eur-rub')
            ->orderBy('r.date', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
