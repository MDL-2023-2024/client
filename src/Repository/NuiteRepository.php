<?php

namespace App\Repository;

use App\Entity\Nuite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository des nuits.
 * 
 * @extends ServiceEntityRepository<Nuite>
 *
 * @method Nuite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nuite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nuite[]    findAll()
 * @method Nuite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NuiteRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Nuite::class);
    }

    public function findByHotelAndCategorie($idHotel, $idCategorie) {
        return $this->createQueryBuilder('n') // 'n' représente une entité Nuit
                        ->innerJoin('n.hotel', 'h')
                        ->innerJoin('n.categorie', 'cat')
                        ->where('h.id = :idHotel')
                        ->andWhere('cat.id = :idCategorie')
                        ->setParameter('idHotel', $idHotel)
                        ->setParameter('idCategorie', $idCategorie)
                        ->getQuery()
                        ->getResult();
    }

//    /**
//     * @return Nuite[] Returns an array of Nuite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
//    public function findOneBySomeField($value): ?Nuite
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
