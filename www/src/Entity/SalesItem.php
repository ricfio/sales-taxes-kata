<?php

declare(strict_types=1);

namespace App\Entity;

use InvalidArgumentException;
use Stringable;

class SalesItem implements Stringable
{
    public function __construct(private string $name, private int $quantity, private float $taxes, private float $total)
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException('sales item quantity must be greater than zero');
        }
    }

    public function __toString()
    {
        return sprintf("%d %s: %.2f\n", $this->getQuantity(), $this->getName(), $this->getTotal());
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTaxes(): float
    {
        return $this->taxes;
    }

    public function getTotal(): float
    {
        return $this->total;
    }
}
