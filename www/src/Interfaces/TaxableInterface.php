<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\ValueObject\Category;

interface TaxableInterface
{
    public function getPrice(): float;

    public function getCategory(): Category;

    public function isImported(): bool;
}
