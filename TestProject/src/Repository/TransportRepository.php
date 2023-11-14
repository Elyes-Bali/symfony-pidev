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

    /**
     * Récupère tous les transports triés par ID ascendant.
     *
     * @return Transport[] Returns an array of Transport objects
     */
    public function findAllTransports()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère un transport par son ID.
     *
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
     * Supprime un transport par son ID.
     *
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

    // Vous pouvez ajouter d'autres méthodes personnalisées en fonction de vos besoins.
}
