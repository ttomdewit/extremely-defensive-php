<?php

declare(strict_types=1);

namespace ExtremelyDefensivePhp\Infrastructure\Repository;

use ExtremelyDefensivePhp\Domain\Aggregate\Carrier;
use ExtremelyDefensivePhp\Domain\Aggregate\Exception\AggregateNotFoundException;
use ExtremelyDefensivePhp\Domain\Repository\CarrierRepositoryInterface;

use function array_key_exists;

final class InMemoryCarrierRepository implements CarrierRepositoryInterface
{
    /** @var Carrier[] */
    private array $carriers = [];

    /** {@inheritDoc} */
    public function getByName(string $carrierName): Carrier
    {
        if (!array_key_exists($carrierName, $this->carriers)) {
            throw new AggregateNotFoundException();
        }

        return $this->carriers[$carrierName];
    }

    public function save(Carrier $carrier): void
    {
        if (array_key_exists($carrier->getName(), $this->carriers)) {
            return;
        }

        $this->carriers[$carrier->getName()] = $carrier;
    }

    /** {@inheritDoc}
     * @return \ExtremelyDefensivePhp\Domain\Aggregate\Carrier[] */
    public function getAll(): array
    {
        return $this->carriers;
    }
}
