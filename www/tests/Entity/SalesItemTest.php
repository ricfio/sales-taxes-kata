<?php

declare(strict_types=1);

use App\Entity\SalesItem;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class SalesItemTest extends TestCase
{
    public function testName(): void
    {
        $item = new SalesItem('book', 2, 0, 24.98);
        $this->assertSame('book', $item->getName());
        $item = new SalesItem('milk', 10, 0, 18.00);
        $this->assertSame('milk', $item->getName());
    }

    public function testQuantity(): void
    {
        $item = new SalesItem('book', 2, 0, 24.98);
        $this->assertSame(2, $item->getQuantity());
        $item = new SalesItem('milk', 10, 0, 18.00);
        $this->assertSame(10, $item->getQuantity());
    }

    public function testQuantityMustBeGreaterThanZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $item = new SalesItem('perfume', 0, 1.90, 20.89);
    }

    public function testTaxes(): void
    {
        $item = new SalesItem('perfume', 1, 1.90, 20.89);
        $this->assertSame(1.90, $item->getTaxes());
    }

    public function testTotal(): void
    {
        $item = new SalesItem('perfume', 1, 1.90, 20.89);
        $this->assertSame(20.89, $item->getTotal());
    }
}
