<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony package.
 * (c) Fabien Potencier <fabien@symfony.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command;

use App\Entity\Payment;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ImportPaymentDataCommand extends Command
{
    /** @var SerializerInterface */
    protected $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        parent::__construct('app:import-payment-data');
        $this->serializer = $serializer;
    }

    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Import payment data from a csv file')
            ->addArgument('filename', InputArgument::REQUIRED, 'Name and location of the filename')
            ->addOption('overwrite', 'o', InputOption::VALUE_OPTIONAL ,'Does the current data needs to be overwritten', false)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename = $input->getArgument('filename');

        if (!file_exists($filename) || !is_readable($filename)) {
            throw new FileNotFoundException(sprintf('File [%s] not found', $filename));
        }

        $output->writeln(sprintf('Importing file [%s]', $filename));

        /** @var ObjectNormalizer $paymentData */
        $paymentData = file_get_contents($filename);
        if($paymentData === null)
        {
            throw new \RuntimeException(sprintf('File [%s] is empty', $filename));
        }

        $payments = $this->serializer->deserialize($paymentData, Payment::class, CsvEncoder::FORMAT);
        foreach ($payments as $payment) {

        }

        $output->writeln('Importing finished!');

        return Command::SUCCESS;
    }
}
