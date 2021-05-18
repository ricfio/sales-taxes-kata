<?php

declare(strict_types=1);

use App\Entity\SalesItem;
use App\Entity\SalesReceipt;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class SalesReceiptTest extends TestCase
{
    public function testItemsCount(): void
    {
        $items = [
            new SalesItem('book', 2, 0, 24.98),
            new SalesItem('milk', 10, 0, 18.00),
            new SalesItem('perfume', 1, 1.90, 20.89),
        ];
        $receipt = new SalesReceipt();
        $this->assertCount(0, $receipt);
        $receipt->addItem($items[0]);
        $this->assertCount(1, $receipt);
        $receipt->addItem($items[1]);
        $this->assertCount(2, $receipt);
        $receipt->addItem($items[2]);
        $this->assertCount(3, $receipt);
    }
}
