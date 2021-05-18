<?php

declare(strict_types=1);

namespace App\Entity;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Stringable;

/**
 * @implements \IteratorAggregate<int, ShoppingItem>
 */
class ShoppingBasket implements Countable, IteratorAggregate, Stringable
{
    /**
     * @param array<int, ShoppingItem> $items
     */
    public function __construct(private array $items = [])
    {
        foreach ($items as $item) {
            if (ShoppingItem::class != get_class($item)) {
                throw new InvalidArgumentException('shopping basket accepts only shopping items');
            }
        }
    }

    public function __toString()
    {
        $buffer = '';
        foreach ($this->items as $item) {
            $product = $item->getProduct();
            $buffer .= sprintf("%d %s at %.2f\n", $item->getQuantity(), $product->getName(), $product->getPrice());
        }

        return $buffer;
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return ArrayIterator<int, ShoppingItem>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function addItem(ShoppingItem $item): void
    {
        $this->items[] = $item;
    }
}
