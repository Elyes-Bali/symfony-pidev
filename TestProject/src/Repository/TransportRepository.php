<?php namespace App\Repository;

use App\Entity\Transport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TransportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transport::class);
    }
    
    public function findByTypeAndDateDepart($searchType, $searchDateDepart)
    {
        $queryBuilder = $this->createQueryBuilder('t');

        if ($searchType) {
            $queryBuilder
                ->andWhere('t.type LIKE :searchType')
                ->setParameter('searchType', '%' . $searchType . '%');
        }

        if ($searchDateDepart) {
            $queryBuilder
                ->andWhere('t.dd = :searchDateDepart')
                ->setParameter('searchDateDepart', new \DateTime($searchDateDepart));
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function countAll()
    {
        return $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countByPriceUnder300()
    {
        return $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.prix < :price')
            ->setParameter('price', 300)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countByPriceAbove300()
    {
        return $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.prix >= :price')
            ->setParameter('price', 300)
            ->getQuery()
            ->getSingleScalarResult();
    }


    public function orderByType()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.type', 'ASC')
            ->getQuery()->getResult();
    }

    public function orderByPrix()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.prix', 'ASC')
            ->getQuery()->getResult();
    }

    public function orderByCapacite()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.cap', 'ASC')
            ->getQuery()->getResult();
    }

    public function orderByDD()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.dd', 'ASC')
            ->getQuery()->getResult();
    }



    /**
     * @return Transport[] 
     */
    public function findAllTransports()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $id
     * @return Transport|null
     */
    public function findTransportById($id)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param int $id
     */
    public function deleteTransportById($id)
    {
        $entityManager = $this->getEntityManager();
        $transport = $this->find($id);

        if ($transport) {
            $entityManager->remove($transport);
            $entityManager->flush();
        }
    }
}
