<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony package.
 * (c) Fabien Potencier <fabien@symfony.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userId;

    /**
     * @ORM\Column(type="integer")
     */
    protected $timestamp;

    /**
     * @ORM\Column(type="string", length=2)
     */
    /** @var string */
    protected $country;

    /**
     * @ORM\Column(type="string", length=3)
     */
    protected $currency;

    /**
     * @ORM\Column(type="integer")
     */
    protected $amount;

    public function getId(): ?int
    {
        return $this->id;
    }

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
