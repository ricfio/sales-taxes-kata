<?php

declare(strict_types=1);

namespace App\Service;

use App\Interfaces\RoundingInterface;

class RoundingUp005 implements RoundingInterface
{
    protected const multiple = 0.05;

    public static function round(float $value): float
    {
        return ceil($value / self::multiple) * self::multiple;
    }
}
