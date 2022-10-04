<?php

declare(strict_types=1);

namespace ExtremelyDefensivePhp\Tests\Unit\Domain\Aggregate;

use ExtremelyDefensivePhp\Domain\Aggregate\Carrier;
use ExtremelyDefensivePhp\Domain\ValueObject\CarrierId;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class CarrierTest extends TestCase
{
    public function testItIsCreatedWithAnIdAndName(): void
    {
        // Given
        $name = 'Agro';

        // When
        $carrier = new Carrier(
            CarrierId::create(),
            $name,
        );

        // Then
        self::assertInstanceOf(Carrier::class, $carrier);
        self::assertInstanceOf(CarrierId::class, $carrier->getId());
        self::assertSame($name, $carrier->getName());
    }
}
