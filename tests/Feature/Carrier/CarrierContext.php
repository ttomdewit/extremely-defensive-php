<?php

declare(strict_types=1);

namespace ExtremelyDefensivePhp\Tests\Feature\Carrier;

use Behat\Behat\Context\Context;
use Exception;
use ExtremelyDefensivePhp\Domain\Aggregate\Carrier;
use ExtremelyDefensivePhp\Domain\ValueObject\CarrierId;
use ExtremelyDefensivePhp\Infrastructure\Repository\InMemoryCarrierRepository;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
final class CarrierContext implements Context
{
    private readonly InMemoryCarrierRepository $carrierRepository;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->carrierRepository = new InMemoryCarrierRepository();
    }

    /**
     * @Given a carrier called :carrierName does not exist
     */
    public function aCarrierCalledDoesNotExist(string $carrierName): void
    {
        $carriers = $this->carrierRepository->getAll();

        Assert::assertArrayNotHasKey($carrierName, $carriers);
    }

    /**
     * @When I create a carrier called :name
     */
    public function iCreateACarrierCalled(string $name): void
    {
        $carrier = new Carrier(
            CarrierId::create(),
            $name,
        );

        $this->carrierRepository->save($carrier);
    }

    /**
     * @Then a carrier called :name exists
     *
     * @throws Exception
     */
    public function aCarrierCalledExists(string $name): void
    {
        $carrier = $this->carrierRepository->getByName($name);

        Assert::assertSame(
            $name,
            $carrier->getName(),
        );
    }

    /**
     * @Then the duplicate carrier is ignored
     */
    public function theDuplicateCarrierIsIgnored(): void
    {
        Assert::assertCount(
            1,
            $this->carrierRepository->getAll(),
        );
    }

    /**
     * @Given a carrier called :name already exists
     */
    public function aCarrierCalledAlreadyExists(string $name): void
    {
        $carrier = new Carrier(
            CarrierId::create(),
            $name,
        );

        $this->carrierRepository->save($carrier);
    }
}
