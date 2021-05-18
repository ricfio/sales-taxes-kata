<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\TaxableInterface;
use App\ValueObject\Category;
use InvalidArgumentException;
use Stringable;

class Product implements Stringable, TaxableInterface
{
    public function __construct(private string $name, private float $price, private Category $category, private bool $imported = false)
    {
        if ($this->price <= 0) {
            throw new InvalidArgumentException('product price must be greater than zero');
        }
    }

    final public function __toString()
    {
        return $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function isImported(): bool
    {
        return $this->imported;
    }

    public function isEqual(Product $other): bool
    {
        return ($this->getName() == $other->getName())
            && ($this->getPrice() == $other->getPrice())
            && ($this->getCategory()->isEqual($other->getCategory()))
            && ($this->isImported() == $other->isImported());
    }
}
