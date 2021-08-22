<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CurrencyConversion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Swap\Swap;

class CurrencyConversionRepository extends ServiceEntityRepository
{
    protected Swap $swap;

    public function __construct(ManagerRegistry $registry, Swap $swap)
    {
        parent::__construct($registry, CurrencyConversion::class);
        $this->swap = $swap;
    }

    public function updateExchangeRates(): void
    {
        foreach ($this->findAll() as $conversion) {
            /* @var CurrencyConversion $conversion */
            $conversion->setRate($this->swap->latest(
                $conversion->getSource().'/'.$conversion->getTarget()
            )->getValue());
        }
        $this->getEntityManager()->flush();
    }
}
