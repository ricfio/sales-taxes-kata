<?php

declare(strict_types=1);

namespace App\Interfaces;

interface RoundingInterface
{
    public static function round(float $value): float;
}
