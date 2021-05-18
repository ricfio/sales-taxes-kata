<?php

declare(strict_types=1);

use App\Entity\Product;
use App\Entity\ShoppingBasket;
use App\Entity\ShoppingItem;
use App\Service\Cashier;
use App\ValueObject\Category;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ApplicationTest extends TestCase
{
    /**
     * @var array<int,ShoppingBasket>
     */
    private array $baskets;

    protected function setUp(): void
    {
        $this->baskets = [
            new ShoppingBasket([
                new ShoppingItem(2, new Product('book', 12.49, new Category(Category::books), false)),
                new ShoppingItem(1, new Product('music CD', 14.99, new Category(Category::various), false)),
                new ShoppingItem(1, new Product('chocolate bar', 0.85, new Category(Category::food), false)),
            ]),
            new ShoppingBasket([
                new ShoppingItem(1, new Product('imported box of chocolates', 10.00, new Category(Category::food), true)),
                new ShoppingItem(1, new Product('imported bottle of perfume', 47.50, new Category(Category::various), true)),
            ]),
            new ShoppingBasket([
                new ShoppingItem(1, new Product('imported bottle of perfume', 27.99, new Category(Category::various), true)),
                new ShoppingItem(1, new Product('bottle of perfume', 18.99, new Category(Category::various), false)),
                new ShoppingItem(1, new Product('packet of headache pills', 9.75, new Category(Category::medical), false)),
                new ShoppingItem(3, new Product('imported box of chocolates', 11.25, new Category(Category::food), true)),
            ]),
        ];
    }

    public function testReceipt1(): void
    {
        $receipt = Cashier::checkout($this->baskets[0]);
        $items = $receipt->getIterator();

        $this->assertCount(3, $items);

        $this->assertTrue($items->valid());
        $item = $items->current();
        $this->assertEquals(2, $item->getQuantity());
        $this->assertEquals(24.98, $item->getTotal());
        $items->next();
        $this->assertTrue($items->valid());
        $item = $items->current();
        $this->assertEquals(1, $item->getQuantity());
        $this->assertEquals(16.49, $item->getTotal());
        $items->next();
        $this->assertTrue($items->valid());
        $item = $items->current();
        $this->assertEquals(1, $item->getQuantity());
        $this->assertEquals(0.85, $item->getTotal());
        $items->next();
        $this->assertFalse($items->valid());

        $this->assertEquals(1.50, $receipt->getTaxes());
        $this->assertEquals(42.32, $receipt->getTotal());
    }

    public function testReceipt2(): void
    {
        $receipt = Cashier::checkout($this->baskets[1]);
        $items = $receipt->getIterator();

        $this->assertCount(2, $items);

        $this->assertTrue($items->valid());
        $item = $items->current();
        $this->assertEquals(1, $item->getQuantity());
        $this->assertEquals(10.50, $item->getTotal());
        $items->next();
        $this->assertTrue($items->valid());
        $item = $items->current();
        $this->assertEquals(1, $item->getQuantity());
        $this->assertEquals(54.65, $item->getTotal());
        $items->next();
        $this->assertFalse($items->valid());

        $this->assertEquals(7.65, $receipt->getTaxes());
        $this->assertEquals(65.15, $receipt->getTotal());
    }

    public function testReceipt3(): void
    {
        $receipt = Cashier::checkout($this->baskets[2]);
        $items = $receipt->getIterator();

        $this->assertCount(4, $items);

        $this->assertTrue($items->valid());
        $item = $items->current();
        $this->assertEquals(1, $item->getQuantity());
        $this->assertEquals(32.19, $item->getTotal());
        $items->next();
        $this->assertTrue($items->valid());
        $item = $items->current();
        $this->assertEquals(1, $item->getQuantity());
        $this->assertEquals(20.89, $item->getTotal());
        $items->next();
        $this->assertTrue($items->valid());
        $item = $items->current();
        $this->assertEquals(1, $item->getQuantity());
        $this->assertEquals(9.75, $item->getTotal());
        $items->next();
        $this->assertTrue($items->valid());
        $item = $items->current();
        $this->assertEquals(3, $item->getQuantity());
        $this->assertEquals(35.55, $item->getTotal());
        $items->next();
        $this->assertFalse($items->valid());

        $this->assertEquals(7.90, $receipt->getTaxes());
        $this->assertEquals(98.38, $receipt->getTotal());
    }
}
