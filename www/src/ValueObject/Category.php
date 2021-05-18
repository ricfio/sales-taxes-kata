<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Common\Enum;

class Category extends Enum
{
    public const books = 1;
    public const food = 2;
    public const medical = 3;
    public const various = 9;

    protected function getExceptionMessage(): string
    {
        return 'Invalid category';
    }
}
