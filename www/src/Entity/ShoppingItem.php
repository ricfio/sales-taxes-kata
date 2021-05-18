<?php

declare(strict_types=1);

namespace App\Entity;

use InvalidArgumentException;

class ShoppingItem
{
    public function __construct(private int $quantity, private Product $product)
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException('shopping item quantity must be greater than zero');
        }
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
