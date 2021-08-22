<?php

declare(strict_types=1);

namespace Serializer;

use App\Entity\Payment;
use App\Serializer\PaymentDenormalizer;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Serializer\PaymentDenormalizer
 * @covers ::__construct
 */
class PaymentDenormalizerTest extends TestCase
{
    protected PaymentDenormalizer $paymentDenormalizer;

    protected function setup(): void
    {
        $this->paymentDenormalizer = new PaymentDenormalizer();
    }

    /**
     * @covers ::supportsDenormalization
     */
    public function testSupportsDenormalization(): void
    {
        $this->assertTrue($this->paymentDenormalizer->supportsDenormalization(null, Payment::class));
        $this->assertFalse($this->paymentDenormalizer->supportsDenormalization(null, \stdClass::class));
    }

    /**
     * @covers ::denormalize
     */
    public function testDenormalizeHappyFlow(): void
    {
        $data = [
            'UserID' => mt_rand(),
            'UnixTimestamp' => mt_rand(),
            'Country' => mt_rand(),
            'Currency' => mt_rand(),
            'AmountInCents' => mt_rand(),
        ];

        $this->assertSame(
            new Payment(
                (string) $data['UserID'],
                (int) $data['UnixTimestamp'],
                (string) $data['Country'],
                (string) $data['Currency'],
                (int) $data['AmountInCents']
            ),
            $this->paymentDenormalizer->denormalize($data, (string) mt_rand())
        );
    }

    /**
     * @covers ::denormalize
     *
     * @dataProvider invalidDataProvider
     */
    public function testDenormalizeThrowsRuntimeException(mixed $data): void
    {
        $this->expectException(\RuntimeException::class);

        $this->paymentDenormalizer->denormalize($data, (string) mt_rand());
    }

    public function invalidDataProvider(): array
    {
        return [
            'empty data' => [[]],
            'column missing' => [['UnixTimestamp' => mt_rand(), 'Country' => mt_rand(), 'Currency' => mt_rand(), 'AmountInCents' => mt_rand()]],
            'extra column' => [[(string) mt_rand() => mt_rand(), 'UserID' => mt_rand(), 'UnixTimestamp' => mt_rand(), 'Country' => mt_rand(), 'Currency' => mt_rand(), 'AmountInCents' => mt_rand()]],
            'no array' => [(object) [(string) mt_rand() => mt_rand()]],
            'null' => [null],
        ];
    }
}
