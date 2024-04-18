<?php

namespace App\Repository;

use App\Entity\StatusInscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StatusInscription>
 *
 * @method StatusInscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusInscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusInscription[]    findAll()
 * @method StatusInscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusInscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatusInscription::class);
    }

//    /**
//     * @return StatusInscription[] Returns an array of StatusInscription objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StatusInscription
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
