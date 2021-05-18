<?php

declare(strict_types=1);

namespace App\Common;

use InvalidArgumentException;
use ReflectionClass;

class Enum
{
    private string $name = '';
    private int $value = 0;

    final public function __construct(int $enum)
    {
        $enumClass = new ReflectionClass(get_class($this));
        $constants = $enumClass->getConstants();
        $found = false;
        foreach ($constants as $name => $value) {
            if ($enum === $value) {
                $found = true;
                $this->name = $name;
                $this->value = $value;

                break;
            }
        }
        if (!$found) {
            $message = sprintf('%s (%d)', $this->getExceptionMessage(), $enum);

            throw new InvalidArgumentException($message);
        }
    }

    protected function getExceptionMessage(): string
    {
        return 'Invalid enum value';
    }

    final public function getName(): string
    {
        return $this->name;
    }

    final public function getValue(): int
    {
        return $this->value;
    }

    final public function isEqual(Enum $other): bool
    {
        return ($this->getName() == $other->getName()) && ($this->getValue() == $other->getValue());
    }
}
