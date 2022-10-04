<?php

declare(strict_types=1);

namespace ExtremelyDefensivePhp\Domain\Repository;

use ExtremelyDefensivePhp\Domain\Aggregate\Carrier;
use ExtremelyDefensivePhp\Domain\Aggregate\Exception\AggregateNotFoundException;

interface CarrierRepositoryInterface
{
    /**
     * @throws AggregateNotFoundException
     */
    public function getByName(string $carrierName): Carrier;

    public function save(Carrier $carrier): void;

    /** @return Carrier[] */
    public function getAll(): array;
}
