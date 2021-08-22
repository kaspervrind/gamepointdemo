<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\CurrencyConversionRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateExchangeRatesCommand extends Command
{
    protected CurrencyConversionRepository $entityManager;

    public function __construct(CurrencyConversionRepository $entityManager)
    {
        parent::__construct('app:update-exchange-rates');
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Update the exchange rates')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->entityManager->updateExchangeRates();

        (new SymfonyStyle($input, $output))->success('Update finished');

        return self::SUCCESS;
    }
}
