<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\SalesItem;
use App\Entity\SalesReceipt;
use App\Entity\ShoppingBasket;
use App\ValueObject\Tax\BasicTax;
use App\ValueObject\Tax\ImportDuty;

class Cashier
{
    public static function checkout(ShoppingBasket $basket): SalesReceipt
    {
        $salesTaxes = [
            new BasicTax(),
            new ImportDuty(),
        ];
        $receipt = new SalesReceipt();
        foreach ($basket as $item) {
            $product = $item->getProduct();

            $taxes = 0;
            foreach ($salesTaxes as $tax) {
                $taxes += TaxEngine::calculate($tax, $product);
            }
            $price = ($product->getPrice() + $taxes);

            $receipt->addItem(
                new SalesItem(
                    name: $product->getName(),
                    quantity: $item->getQuantity(),
                    taxes: $taxes * $item->getQuantity(),
                    total: $price * $item->getQuantity(),
                )
            );
        }

        return $receipt;
    }
}
