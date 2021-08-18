<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Payment;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PaymentNormalizer implements DenormalizerInterface
{
    public function denormalize($data, string $type, string $format = null, array $context = []): array
    {
        $result = [];
        $line = 1;

        if (empty($data))
        {
            throw new \RuntimeException('File contains no data');
        }

        $columns = ['UserID', 'UnixTimestamp', 'Country', 'Currency', 'AmountInCents'];
        if (array_keys(current($data)) !== $columns){
            throw new \RuntimeException(sprintf('File contains an invalid set of columns. Format [%s]', implode(',', $columns)));
        }

        foreach ($data as $paymentData) {
            $result[] = new Payment(
                (string) $paymentData['UserID'],
                (int) $paymentData['UnixTimestamp'],
                (string) $paymentData['Country'],
                (string) $paymentData['Currency'],
                (int) $paymentData['AmountInCents']
            );
        }

        return $result;
    }

    public function supportsDenormalization($data, string $type, string $format = null): bool
    {
        return is_a($type, Payment::class, true);
    }
}
