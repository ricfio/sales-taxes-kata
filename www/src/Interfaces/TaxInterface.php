<?php

declare(strict_types=1);

namespace App\Interfaces;

interface TaxInterface
{
    public function getRate(): float;

    public function getRounding(): RoundingInterface;

    public function isApplicable(TaxableInterface $product): bool;
}
