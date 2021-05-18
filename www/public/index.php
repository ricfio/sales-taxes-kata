<?php

declare(strict_types=1);

require_once 'autoload.php';

use App\Entity\Product;
use App\Entity\ShoppingBasket;
use App\Entity\ShoppingItem;
use App\Service\Cashier;
use App\ValueObject\Category;

/**
 * @param array<int,ShoppingBasket> $baskets
 */
function shoppingBasketsToString(array $baskets): string
{
    $buffer = "\nINPUT\n\n";
    foreach ($baskets as $key => $basket) {
        $buffer .= sprintf("Input %d:\n", $key + 1);
        $buffer .= $basket->__toString();
        $buffer .= "\n";
    }

    return $buffer;
}

/**
 * @param array<int,SalesReceipt> $receipts
 */
function salesReceiptsToString(array $receipts): string
{
    $buffer = "\nOUTPUT\n\n";
    foreach ($receipts as $key => $receipt) {
        $buffer .= sprintf("Output %d:\n", $key + 1);
        $buffer .= $receipt->__toString();
        $buffer .= "\n";
    }

    return $buffer;
}

$baskets = [
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

$receipts = [];
foreach ($baskets as $key => $basket) {
    $receipts[] = Cashier::checkout($basket);
}

header('Content-Type: text/plain');
echo shoppingBasketsToString($baskets);
echo salesReceiptsToString($receipts);
