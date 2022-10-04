<?php

declare(strict_types=1);

namespace ExtremelyDefensivePhp\Domain\Aggregate;

use ExtremelyDefensivePhp\Domain\ValueObject\CarrierId;

final class Carrier
{
    public function __construct(
        private readonly CarrierId $carrierId,
        private readonly string $name,
    ) {
    }

    public function getId(): CarrierId
    {
        return $this->carrierId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
