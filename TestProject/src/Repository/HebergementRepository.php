<?php

namespace App\Repository;

use App\Entity\Hebergement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hebergement>
 *
 * @method Hebergement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hebergement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hebergement[]    findAll()
 * @method Hebergement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HebergementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hebergement::class);
    }


    public function orderByType()
    {
        return $this->createQueryBuilder('h')
            ->orderBy('h.type', 'ASC')
            ->getQuery()->getResult();
    }

    public function orderByAdresse()
    {
        return $this->createQueryBuilder('h')
            ->orderBy('h.adresse', 'ASC')
            ->getQuery()->getResult();
    }

    public function orderByCapacite()
    {
        return $this->createQueryBuilder('h')
            ->orderBy('h.capacite', 'ASC')
            ->getQuery()->getResult();
    }

    public function orderByPrix()
    {
        return $this->createQueryBuilder('h')
            ->orderBy('h.prix', 'ASC')
            ->getQuery()->getResult();
    }

//    /**
//     * @return Hebergement[] Returns an array of Hebergement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Hebergement
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
