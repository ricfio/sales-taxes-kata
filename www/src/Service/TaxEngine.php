<?php

declare(strict_types=1);

namespace App\Service;

use App\Interfaces\TaxableInterface;
use App\Interfaces\TaxInterface;

class TaxEngine
{
    public static function calculate(TaxInterface $tax, TaxableInterface $product): float
    {
        if ($tax->isApplicable($product)) {
            $rounding = $tax->getRounding();

            return $rounding->round($product->getPrice() * ($tax->getRate() / 100));
        }

        return 0;
    }
}
