<?php

declare(strict_types=1);

use App\ValueObject\Category;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CategoryTest extends TestCase
{
    public function testName(): void
    {
        $category = new Category(Category::books);
        $this->assertSame('books', $category->getName());
    }

    public function testValue(): void
    {
        $category = new Category(Category::books);
        $this->assertSame(Category::books, $category->getValue());
    }

    public function testIsEqual(): void
    {
        $category_books = new Category(Category::books);
        $category_food1 = new Category(Category::food);
        $category_food2 = new Category(Category::food);
        $this->assertFalse($category_books->isEqual($category_food1));
        $this->assertFalse($category_books->isEqual($category_food2));
        $this->assertTrue($category_food1->isEqual($category_food2));
    }
}
