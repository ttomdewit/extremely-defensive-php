<?php

declare(strict_types=1);

namespace ExtremelyDefensivePhp\Domain\ValueObject;

use ExtremelyDefensivePhp\Domain\ValueObject\Exception\NoValidUUIDString;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class CarrierId
{
    private readonly string $id;

    private function __construct(UuidInterface $id)
    {
        $this->id = $id->toString();
    }

    public static function create(): self
    {
        return new self(Uuid::uuid4());
    }

    /** @throws NoValidUUIDString */
    public static function fromString(string $uuid): self
    {
        if (!Uuid::isValid($uuid)) {
            throw new NoValidUUIDString(
                sprintf(
                    '[%s] is not a valid UUID string',
                    $uuid,
                ),
            );
        }

        return new self(Uuid::fromString($uuid));
    }

    public function toString(): string
    {
        return $this->id;
    }
}
