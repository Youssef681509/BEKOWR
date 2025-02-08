<?php

namespace App\Repository;

use App\Entity\Donation;
//use App\Entity\Beneficiary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Donation>
 */
class DonationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Donation::class);
    }


    //YGH
 //public function findActiveBeneficiaries(): array
 //{
     //return $this->createQueryBuilder('b')
        // ->where('b.status = :status')
        // ->andWhere('b.enable = :enable')
        // ->setParameter('status', true)
        // ->setParameter('enable', true)
        // ->getQuery()
        // ->getResult();
 //}

//    /**
//     * @return Donation[] Returns an array of Donation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Donation
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
