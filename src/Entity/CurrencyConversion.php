<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony package.
 * (c) Fabien Potencier <fabien@symfony.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class CurrencyConversion
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    protected string $source;

    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    protected string $target;

    /**
     * @ORM\Column(type="decimal")
     */
    protected float $rate;

    public function __construct(string $source, string $target, float $rate)
    {
        $this->source = $source;
        $this->target = $target;
        $this->rate = $rate;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getTarget(): string
    {
        return $this->target;
    }

    public function getRate(): float
    {
        return $this->rate;
    }
}
