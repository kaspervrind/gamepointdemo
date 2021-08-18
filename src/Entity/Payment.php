<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony package.
 * (c) Fabien Potencier <fabien@symfony.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

class Payment
{
    /** @var string */
    protected $userId;
    /** @var int */
    protected $timestamp;
    /** @var string */
    protected $country;
    /** @var string */
    protected $currency;
    /** @var int */
    protected $amount;

    public function __construct(string $userId, int $timestamp, string $country, string $currency, int $amount)
    {
        $this->userId = $userId;
        $this->timestamp = $timestamp;
        $this->country = $country;
        $this->currency = $currency;
        $this->amount = $amount;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
