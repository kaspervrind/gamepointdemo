<?php

namespace App\DataFixtures;

use App\Entity\CurrencyConversion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Swap\Swap;

class CurrencyConversionFixture extends Fixture
{
    protected Swap $swap;

    public function __construct(Swap $swap)
    {
        $this->swap = $swap;
    }

    public function load(ObjectManager $manager)
    {
        $manager->persist(new CurrencyConversion('EUR', 'EUR', 1.0000));
        $manager->persist(new CurrencyConversion('USD', 'EUR', $this->swap->latest('USD/EUR')->getValue()));
        $manager->persist(new CurrencyConversion('NOK', 'EUR', $this->swap->latest('NOK/EUR')->getValue()));
        $manager->persist(new CurrencyConversion('CAD', 'EUR', $this->swap->latest('CAD/EUR')->getValue()));

        $manager->flush();
    }
}
