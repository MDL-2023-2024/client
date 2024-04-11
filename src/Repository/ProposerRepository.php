<?php

namespace App\Repository;

use App\Entity\Proposer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository des proposers.
 * 
 * @extends ServiceEntityRepository<Proposer>
 *
 * @method Proposer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proposer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proposer[]    findAll()
 * @method Proposer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProposerRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Proposer::class);
    }

    public function findByHotelAndCategorie($idHotel, $idCategorie) {
        return $this->createQueryBuilder('p')
                        ->innerJoin('p.hotel', 'h')
                        ->innerJoin('p.categorie', 'cat')
                        ->where('h.id = :idHotel')
                        ->andWhere('cat.id = :idCategorie')
                        ->setParameter('idHotel', $idHotel)
                        ->setParameter('idCategorie', $idCategorie)
                        ->getQuery()
                        ->getResult();
    }

//    /**
//     * @return Proposer[] Returns an array of Proposer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
//    public function findOneBySomeField($value): ?Proposer
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
