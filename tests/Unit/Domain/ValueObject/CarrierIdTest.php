<?php

declare(strict_types=1);

namespace ExtremelyDefensivePhp\Tests\Unit\Domain\ValueObject;

use ExtremelyDefensivePhp\Domain\ValueObject\CarrierId;
use ExtremelyDefensivePhp\Domain\ValueObject\Exception\NoValidUUIDString;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class CarrierIdTest extends TestCase
{
    public function testItCanBeCreatedWithoutArgument(): void
    {
        // When
        $carrierId = CarrierId::create();

        // Then
        self::assertInstanceOf(CarrierId::class, $carrierId);
    }

    public function testItCanBeCreatedWithValidUuid(): void
    {
        // Given
        $uuid = '4b04cc2d-f6d0-4bf8-adb6-d9e1f5e2aa6e';

        // When
        $carrierId = CarrierId::fromString($uuid);

        // Then
        self::assertInstanceOf(CarrierId::class, $carrierId);
        self::assertSame($uuid, $carrierId->toString());
    }

    public function testItThrowsAnExceptionWhenCreatedFromInvalidString(): void
    {
        // Then
        $this->expectException(NoValidUUIDString::class);
        $this->expectExceptionMessage('[not-a-valid-uuid] is not a valid UUID string');

        // Given
        $notAValidUuid = 'not-a-valid-uuid';

        // When
        CarrierId::fromString($notAValidUuid);
    }
}
