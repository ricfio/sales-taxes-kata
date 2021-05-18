<?php

declare(strict_types=1);

use App\Service\RoundingUp005;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class RoundingUp005Test extends TestCase
{
    public function testRound(): void
    {
        $this->assertSame(0.00, RoundingUp005::round(0.00));
        $this->assertSame(0.05, RoundingUp005::round(0.01));
        $this->assertSame(0.05, RoundingUp005::round(0.02));
        $this->assertSame(0.05, RoundingUp005::round(0.03));
        $this->assertSame(0.05, RoundingUp005::round(0.04));
        $this->assertSame(0.05, RoundingUp005::round(0.05));
        $this->assertSame(0.10, RoundingUp005::round(0.06));
        $this->assertSame(0.10, RoundingUp005::round(0.07));
        $this->assertSame(0.10, RoundingUp005::round(0.08));
        $this->assertSame(0.10, RoundingUp005::round(0.09));
        $this->assertSame(0.10, RoundingUp005::round(0.10));
        $this->assertSame(0.15, RoundingUp005::round(0.11));
        $this->assertSame(0.90, RoundingUp005::round(0.89));
        $this->assertSame(0.90, RoundingUp005::round(0.90));
        $this->assertSame(0.95, RoundingUp005::round(0.91));
        $this->assertSame(0.95, RoundingUp005::round(0.92));
        $this->assertSame(0.95, RoundingUp005::round(0.93));
        $this->assertSame(0.95, RoundingUp005::round(0.94));
        $this->assertSame(0.95, RoundingUp005::round(0.95));
        $this->assertSame(1.00, RoundingUp005::round(0.96));
        $this->assertSame(1.00, RoundingUp005::round(0.97));
        $this->assertSame(1.00, RoundingUp005::round(0.98));
        $this->assertSame(1.00, RoundingUp005::round(0.99));
        $this->assertSame(1.00, RoundingUp005::round(1.00));
        $this->assertSame(1.05, RoundingUp005::round(1.01));
    }
}
