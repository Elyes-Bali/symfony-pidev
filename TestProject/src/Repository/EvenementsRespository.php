<?php

namespace App\Repository;

use App\Entity\Evenements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @extends ServiceEntityRepository<Evenements>
 *
 * @method Evenements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenements[]    findAll()
 * @method Evenements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementsRespository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenements::class);
    }

    public function findByCategory($categoryId): array
    {
        return $this->createQueryBuilder('e')
            ->join('e.category', 'c')
            ->andWhere('c.id = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
//    /**
//     * @return Evenements[] Returns an array of Evenements objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evenements
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
// Add these methods to your EvenementsRepository

public function countByCategorie()
{
    return $this->createQueryBuilder('e')
        ->select('c.nom as category, COUNT(e.id) as eventCount')
        ->leftJoin('e.categorie', 'c')
        ->groupBy('c.id')
        ->getQuery()
        ->getResult();
}
public function getCategoriesCount()
{
    return $this->createQueryBuilder('e')
        ->select('c.nom', 'COUNT(e.id) as total')
        ->leftJoin('e.categorie', 'c')
        ->groupBy('c.nom')
        ->getQuery()
        ->getResult();
}



}