<?php

declare(strict_types=1);

use App\Entity\Product;
use App\Entity\ShoppingBasket;
use App\Entity\ShoppingItem;
use App\ValueObject\Category;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ShoppingBasketTest extends TestCase
{
    public function testConstructorAcceptOnlyShoppingItems(): void
    {
        $this->expectException(InvalidArgumentException::class);
        // @phpstan-ignore-next-line
        new ShoppingBasket([
            new stdClass(),
        ]);
    }

    public function testShoppingItemsCount(): void
    {
        $items = [
            new ShoppingItem(3, new Product('book', 12.49, new Category(Category::books), false)),
            new ShoppingItem(3, new Product('imported box of chocolates', 11.25, new Category(Category::food), true)),
            new ShoppingItem(1, new Product('imported bottle of perfume', 47.50, new Category(Category::various), true)),
        ];
        $basket = new ShoppingBasket();
        $this->assertCount(0, $basket);
        $basket->addItem($items[0]);
        $this->assertCount(1, $basket);
        $basket->addItem($items[1]);
        $this->assertCount(2, $basket);
        $basket->addItem($items[2]);
        $this->assertCount(3, $basket);
        $basket = new ShoppingBasket($items);
        $this->assertCount(3, $basket);
    }
}
