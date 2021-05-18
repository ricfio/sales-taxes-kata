<?php

declare(strict_types=1);

namespace App\ValueObject\Tax;

use App\Interfaces\RoundingInterface;
use App\Interfaces\TaxableInterface;
use App\Interfaces\TaxInterface;
use Stringable;

abstract class AbstractTax implements Stringable, TaxInterface
{
    public function __construct(private string $name, private float $rate, private RoundingInterface $rounding)
    {
    }

    final public function __toString()
    {
        return $this->name;
    }

    final public function getRate(): float
    {
        return $this->rate;
    }

    final public function getRounding(): RoundingInterface
    {
        return $this->rounding;
    }

    abstract public function isApplicable(TaxableInterface $product): bool;
}
