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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ImportPaymentDataCommand extends Command
{
    protected const FILE_FOLDER = '/app/tmp/';
    protected const COMMIT_THRESHOLD = 1000;

    protected DenormalizerInterface $denormalizer;
    protected EntityManagerInterface $entityManager;

    public function __construct(DenormalizerInterface $denormalizer, EntityManagerInterface $entityManager)
    {
        parent::__construct('app:import-payment-data');

        $this->denormalizer = $denormalizer;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Import payment data from a csv file')
            ->addArgument('filename', InputArgument::REQUIRED, 'Name and location of the filename')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);
        $style->title('Importing payment data into the database');

        $fileObject = new \SplFileObject(self::FILE_FOLDER.$input->getArgument('filename'), 'r');

        if (!$fileObject->isFile() || !$fileObject->isReadable()) {
            $style->error(sprintf('File [%s] not found', $fileObject->getFilename()));

            return Command::FAILURE;
        }

        $overwrite = $style->ask('Overwrite current data?', 'true');
        if ('true' === $overwrite) {
            $style->writeln('Clearing current data ');
            $this->entityManager
                ->getRepository(Payment::class)
                ->clearPayments()
            ;
        }

        $style->info(sprintf('Importing file [%s]', $fileObject->getFilename()));

        try {
            $this->importPaymentData($style, $fileObject);
        } catch (\Throwable $e) {
            $style->error($e->getMessage());

            return Command::FAILURE;
        }

        $style->info('Importing finished!');

        return Command::SUCCESS;
    }

    protected function importPaymentData(SymfonyStyle $style, \SplFileObject $file): void
    {
        $headers = $file->current();
        if (!$headers) {
            throw new \RuntimeException('File is empty');
        }

        $lineNumber = 0;
        $file->next();

        // Iterate over every line of the file
        while (!$file->eof()) {
            $values = $file->current();

            //empty line
            if (empty($values)) {
                continue;
            }

            $payment = $this->denormalizer->denormalize(
                array_combine(
                    str_getcsv($headers), str_getcsv($values)
                ),
                Payment::class,
                CsvEncoder::FORMAT
            );
            $this->entityManager->persist($payment);

            // flush the entries when the threshold is met.
            if (0 === $lineNumber % self::COMMIT_THRESHOLD) {
                $this->entityManager->flush();
            }

            // Increase the current line
            ++$lineNumber;
            $file->next();
        }

        $style->info(sprintf('%d lines imported.', $lineNumber));
        $this->entityManager->flush();
    }
}
