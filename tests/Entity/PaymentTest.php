<?php

declare(strict_types=1);

namespace Entity;

use App\Entity\Payment;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Entity\Payment
 * @covers ::__construct
 */
class PaymentTest extends TestCase
{
    protected ?Payment $payment;
    protected ?string $userId;
    protected ?int $timestamp;
    protected ?string $country;
    protected ?string $currency;
    protected ?int $amount;

    protected function setUp(): void
    {
        $this->userId = (string) mt_rand();
        $this->timestamp = mt_rand();
        $this->country = (string) mt_rand();
        $this->currency = (string) mt_rand();
        $this->amount = mt_rand();

        $this->payment = new Payment(
            $this->userId,
            $this->timestamp,
            $this->country,
            $this->currency,
            $this->amount
        );
    }

    /**
     * @covers ::getTimestamp
     */
    public function testGetTimestamp(): void
    {
        self::assertSame($this->timestamp, $this->payment->getTimestamp());
    }

    /**
     * @covers ::getCurrency
     */
    public function testGetCurrency(): void
    {
        self::assertSame($this->currency, $this->payment->getCurrency());
    }

    /**
     * @covers ::getUserId
     */
    public function testGetUserId(): void
    {
        self::assertSame($this->userId, $this->payment->getUserId());
    }

    /**
     * @covers ::getCountry
     */
    public function testGetCountry(): void
    {
        self::assertSame($this->country, $this->payment->getCountry());
    }

    /**
     * @covers ::getAmount
     */
    public function testGetAmount(): void
    {
        self::assertSame($this->amount, $this->payment->getAmount());
    }

    /**
     * @covers ::getId
     */
    public function testGetId(): void
    {
        $id = mt_rand();

        $property = new \ReflectionProperty($this->payment, 'id');
        $property->setAccessible(true);
        $property->setValue($this->payment, $id);

        self::assertSame($id, $this->payment->getId());
    }

    /**
     * @covers ::setId
     */
    public function testSetId(): void
    {
        $id = mt_rand();

        $property = new \ReflectionProperty($this->payment, 'id');
        $property->setAccessible(true);

        self::assertSame($this->payment, $this->payment->setId($id));
        self::assertSame($id, $property->getValue($this->payment));
    }
}
