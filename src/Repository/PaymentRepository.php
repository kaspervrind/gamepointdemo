<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Payment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
    }

    public function clearPayments(): void
    {
        $this
            ->getEntityManager()
            ->getConnection()
            ->executeQuery('TRUNCATE payment');
    }

    public function revenuePerCurrency(): array
    {
        return $this
            ->createQueryBuilder('p')
            ->select('p.currency, SUM(p.amount) as amount')
            ->groupBy('p.currency')
            ->orderBy('p.currency')
            ->getQuery()
            ->getArrayResult();
    }

    public function revenuePerUser(): array
    {
        return $this
            ->createQueryBuilder('p')
            ->select('p.userId, SUM(p.amount) as amount, p.currency')
            ->groupBy('p.userId, p.currency')
            ->orderBy('p.userId')
            ->getQuery()
            ->getArrayResult();
    }

    public function revenueEuroPerDay(): array
    {
        return $this->getEntityManager()
            ->getConnection()
            ->prepare(
                <<<'SQL'
                select to_timestamp(timestamp)::date as "date", sum(amount * c.rate) as amount
                from payment p
                JOIN currency_conversion c ON p.currency = c.source AND c.target = 'EUR'
                GROUP BY to_timestamp(timestamp)::date
                ORDER BY "date" DESC
            SQL)
            ->executeQuery()
            ->fetchAllAssociative()
            ;
    }
}
