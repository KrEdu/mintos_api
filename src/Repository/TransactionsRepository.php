<?php

namespace App\Repository;

use App\Entity\Transactions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transactions>
 *
 * @method Transactions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transactions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transactions[]    findAll()
 * @method Transactions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transactions::class);
    }

    /**
     * @return Transactions[]
     */
    public function findByAccountId(int $accountId, ?int $offset = 0, ?int $limit = 0): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.account_from = :val')
            ->orWhere('t.account_to= :val')
            ->setParameter('val', $accountId)
            ->orderBy('t.date', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
}
