<?php

namespace App\Repository;

use App\Entity\ATDeviceType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ATDeviceType>
 *
 * @method ATDeviceType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ATDeviceType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ATDeviceType[]    findAll()
 * @method ATDeviceType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ATDeviceTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ATDeviceType::class);
    }

    public function add(ATDeviceType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ATDeviceType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ATDeviceType[] Returns an array of ATDeviceType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ATDeviceType
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
