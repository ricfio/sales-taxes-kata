<?php

declare(strict_types=1);

use App\Entity\Product;
use App\Entity\ShoppingItem;
use App\ValueObject\Category;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ShoppingItemTest extends TestCase
{
    public function testQuantity(): void
    {
        $book = new Product('book', 12.49, new Category(Category::books), false);
        $item = new ShoppingItem(3, $book);
        $this->assertSame(3, $item->getQuantity());
        $this->assertNotSame(1, $item->getQuantity());
    }

    public function testQuantityMustBeGreaterThanZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $book = new Product('book', 12.49, new Category(Category::books), false);
        $item = new ShoppingItem(0, $book);
    }

    public function testProduct(): void
    {
        $book = new Product('book', 12.49, new Category(Category::books), false);
        $item = new ShoppingItem(3, new Product('book', 12.49, new Category(Category::books), false));
        $this->assertTrue($item->getProduct()->isEqual(new Product('book', 12.49, new Category(Category::books), false)));
        $this->assertFalse($item->getProduct()->isEqual(new Product('chocolate bar', 0.85, new Category(Category::food), false)));
    }
}
