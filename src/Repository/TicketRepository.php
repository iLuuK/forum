<?php

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ticket>
 *
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    public function add(Ticket $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ticket $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLast(): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.is_deleted = :val')
            ->setParameter('val', false)
            ->orderBy('t.updated_at', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

   public function findByCategory($value): array
   {
       return $this->createQueryBuilder('t')
           ->andWhere('t.category = :val')
           ->setParameter('val', $value)
           ->andWhere('t.is_deleted = :val2')
           ->setParameter('val2', false)
           ->orderBy('t.updated_at', 'DESC')
           ->getQuery()
           ->getResult();
   }

//    public function findOneBySomeField($value): ?Ticket
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
