<?php

declare(strict_types=1);

namespace Entity;

use App\Entity\CurrencyConversion;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Entity\CurrencyConversion
 * @covers ::__construct
 */
class CurrencyConversionTest extends TestCase
{
    protected string $source;
    protected string $target;
    protected float $rate;
    protected CurrencyConversion $conversion;

    protected function setUp(): void
    {
        $this->source = (string) mt_rand();
        $this->target = (string) mt_rand();
        $this->rate = (float) mt_rand();

        $this->conversion = new CurrencyConversion(
            $this->source,
            $this->target,
            $this->rate
        );
    }

    /**
     * @covers ::getTarget
     */
    public function testGetTarget(): void
    {
        self::assertSame($this->target, $this->conversion->getTarget());
    }

    /**
     * @covers ::getRate
     */
    public function testGetRate(): void
    {
        self::assertSame($this->rate, $this->conversion->getRate());
    }

    /**
     * @covers ::getSource
     */
    public function testGetSource(): void
    {
        self::assertSame($this->source, $this->conversion->getSource());
    }

    /**
     * @covers ::setRate
     */
    public function testSetRate(): void
    {
        $rate = (float) mt_rand();

        $property = new \ReflectionProperty($this->conversion, 'rate');
        $property->setAccessible(true);

        self::assertSame($this->conversion, $this->conversion->setRate($rate));
        self::assertSame($rate, $property->getValue($this->conversion));
    }
}
