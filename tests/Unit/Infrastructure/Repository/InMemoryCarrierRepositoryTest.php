<?php

declare(strict_types=1);

namespace ExtremelyDefensivePhp\Tests\Unit\Infrastructure\Repository;

use ExtremelyDefensivePhp\Domain\Aggregate\Carrier;
use ExtremelyDefensivePhp\Domain\Aggregate\Exception\AggregateNotFoundException;
use ExtremelyDefensivePhp\Domain\ValueObject\CarrierId;
use ExtremelyDefensivePhp\Infrastructure\Repository\InMemoryCarrierRepository;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class InMemoryCarrierRepositoryTest extends TestCase
{
    private InMemoryCarrierRepository $carrierRepository;

    protected function setUp(): void
    {
        $this->carrierRepository = new InMemoryCarrierRepository();
    }

    public function testItCanFindCarrierByName(): void
    {
        // Given
        $this->carrierRepository->save(
            new Carrier(
                CarrierId::create(),
                'Agro',
            )
        );

        // When
        $carrier = $this->carrierRepository->getByName('Agro');

        // Then
        self::assertSame(
            $carrier->getName(),
            'Agro',
        );
    }

    public function testItCanNotFindNonExistingCarrierByName(): void
    {
        // Then
        $this->expectException(AggregateNotFoundException::class);

        // Given
        $this->carrierRepository->save(
            new Carrier(
                CarrierId::create(),
                'Agro',
            )
        );

        // When
        $this->carrierRepository->getByName('Another Agro');
    }

    public function testItCanGetAllCarriers(): void
    {
        // Given
        $this->carrierRepository->save(
            new Carrier(
                CarrierId::create(),
                'Agro',
            )
        );

        $this->carrierRepository->save(
            new Carrier(
                CarrierId::create(),
                'Another Agro',
            )
        );

        // When
        $carriers = $this->carrierRepository->getAll();

        // Then
        self::assertCount(2, $carriers);
    }

    public function testItCanOnlySafeOneUniqueName(): void
    {
        // Given
        $this->carrierRepository->save(
            new Carrier(
                CarrierId::create(),
                'Agro',
            )
        );

        // @phan-suppress-next-line PhanPluginDuplicateAdjacentStatement
        $this->carrierRepository->save(
            new Carrier(
                CarrierId::create(),
                'Agro',
            )
        );

        // When
        $carriers = $this->carrierRepository->getAll();

        // Then
        self::assertCount(1, $carriers);
    }
}
