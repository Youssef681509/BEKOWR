<?php

namespace App\Repository;

use App\Entity\Beneficiary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Beneficiary>
 */
class BeneficiaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Beneficiary::class);
    }

 //YGH
 public function findActiveBeneficiaries(): array
{
    return $this->createQueryBuilder('b')
        ->where('b.status = :status')
        ->andWhere('b.etat = :etat')
        ->setParameter('status', true)
        ->setParameter('etat', true)
        ->getQuery()
        ->getResult();
}
 
 

//    /**
//     * @return Beneficiary[] Returns an array of Beneficiary objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Beneficiary
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
