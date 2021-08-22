<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Payment;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PaymentDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, string $type, string $format = null, array $context = []): Payment
    {
        $columns = ['UserID', 'UnixTimestamp', 'Country', 'Currency', 'AmountInCents'];
        if (!\is_array($data)) {
            throw new \RuntimeException('No array data provided');
        }

        if (array_keys($data) !== $columns) {
            throw new \RuntimeException(sprintf('File contains an invalid set of columns. Format [%s]', implode(',', $columns)));
        }

        return new Payment(
            (string) $data['UserID'],
            (int) $data['UnixTimestamp'],
            (string) $data['Country'],
            (string) $data['Currency'],
            (int) $data['AmountInCents']
        );
    }

    public function supportsDenormalization($data, string $type, string $format = null): bool
    {
        return is_a($type, Payment::class, true);
    }
}
