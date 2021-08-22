<?php

namespace App\DataFixtures;

use App\Entity\CurrencyConversion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyConversionFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manager->persist(new CurrencyConversion('EUR', 'EUR', 1.0000));
        $manager->persist(new CurrencyConversion('USD', 'EUR', 0.8600));
        $manager->persist(new CurrencyConversion('NOK', 'EUR', 0.0950));
        $manager->persist(new CurrencyConversion('CAD', 'EUR', 0.6700));

        $manager->flush();
    }
}
