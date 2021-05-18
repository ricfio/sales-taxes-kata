<?php

declare(strict_types=1);

namespace App\ValueObject\Tax;

use App\Interfaces\TaxableInterface;
use App\Service\RoundingUp005;

class ImportDuty extends AbstractTax
{
    public function __construct()
    {
        parent::__construct('Import duty', 5, new RoundingUp005());
    }

    public function isApplicable(TaxableInterface $product): bool
    {
        return $product->isImported();
    }
}
