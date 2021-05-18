<?php

declare(strict_types=1);

namespace App\Entity;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Stringable;

/**
 * @implements \IteratorAggregate<int, SalesItem>
 */
class SalesReceipt implements Countable, IteratorAggregate, Stringable
{
    /**
     * @var array<int, SalesItem>
     */
    private array $items = [];

    private float $taxes = 0;
    private float $total = 0;

    public function __toString()
    {
        $buffer = '';
        foreach ($this->items as $item) {
            $buffer .= $item->__toString();
        }
        $buffer .= sprintf("Sales Taxes: %.2f\n", $this->getTaxes());
        $buffer .= sprintf("Total: %.2f\n", $this->getTotal());

        return $buffer;
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return ArrayIterator<int, SalesItem>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function addItem(SalesItem $item): void
    {
        $this->items[] = $item;
        $this->taxes += $item->getTaxes();
        $this->total += $item->getTotal();
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
