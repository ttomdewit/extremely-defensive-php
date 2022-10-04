<?php

declare(strict_types=1);

namespace ExtremelyDefensivePhp\Application;

use ExtremelyDefensivePhp\Domain\ValueObject\CarrierId;

final class Command
{
    private readonly string $carrierId;

    public function __construct(
        CarrierId $carrierId,
    ) {
        $this->carrierId = $carrierId->toString();
    }

    public function getCarrierId(): CarrierId
    {
        return CarrierId::fromString($this->carrierId);
    }
}
