<?php

declare(strict_types=1);

use App\Entity\Product;
use App\ValueObject\Category;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ProductTest extends TestCase
{
    public function testName(): void
    {
        $product = new Product('book', 12.49, new Category(Category::books));
        $this->assertSame('book', $product->getName());
        $this->assertNotSame('imported box of chocolates', $product->getName());
    }

    public function testPrice(): void
    {
        $product = new Product('book', 12.49, new Category(Category::books));
        $this->assertSame(12.49, $product->getPrice());
        $this->assertNotSame(33.75, $product->getPrice());
    }

    public function testPriceMustBeGreaterThanZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $product = new Product('book', 0.00, new Category(Category::books), false);
    }

    public function testCategory(): void
    {
        $product = new Product('book', 12.49, new Category(Category::books), false);
        $product_category = $product->getCategory();
        $this->assertTrue($product_category->isEqual(new Category(Category::books)));
        $this->assertFalse($product_category->isEqual(new Category(Category::food)));
    }

    public function testImported(): void
    {
        $national = new Product('national milk', 0.99, new Category(Category::food), false);
        $this->assertFalse($national->isImported());
        $imported = new Product('imported milk', 1.39, new Category(Category::food), true);
        $this->assertTrue($imported->isImported());
    }

    public function testIsEqual(): void
    {
        $product = new Product('book', 12.49, new Category(Category::books), false);
        $this->assertTrue($product->isEqual(new Product('book', 12.49, new Category(Category::books), false)));
        $this->assertFalse($product->isEqual(new Product('clean code', 12.49, new Category(Category::books), false)));
        $this->assertFalse($product->isEqual(new Product('book', 23.57, new Category(Category::books), false)));
        $this->assertFalse($product->isEqual(new Product('book', 12.49, new Category(Category::food), false)));
        $this->assertFalse($product->isEqual(new Product('book', 12.49, new Category(Category::books), true)));
    }
}
