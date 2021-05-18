<?php

declare(strict_types=1);

namespace App\ValueObject\Tax;

use App\Interfaces\TaxableInterface;
use App\Service\RoundingUp005;
use App\ValueObject\Category;

class BasicTax extends AbstractTax
{
    public static $taxFreeCategories = [
        Category::books,
        Category::food,
        Category::medical,
    ];

    public function __construct()
    {
        parent::__construct('Basic tax', 10, new RoundingUp005());
    }

    public function isApplicable(TaxableInterface $product): bool
    {
        return !in_array($product->getCategory()->getValue(), self::$taxFreeCategories);
    }
}
