<?php

namespace App\Repository;

use App\Entity\CategorieHeb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorieHeb>
 *
 * @method CategorieHeb|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieHeb|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieHeb[]    findAll()
 * @method CategorieHeb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieHebRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieHeb::class);
    }

//    /**
//     * @return CategorieHeb[] Returns an array of CategorieHeb objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CategorieHeb
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
