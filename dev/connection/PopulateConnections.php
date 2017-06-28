<?php

namespace Yosmy\Voip\Dev;

use Yosmy\GenerateFake;
use Yosmy\Voip;
use Yosmy\Phone;

/**
 * @di\service()
 */
class PopulateConnections
{
    /**
     * @var Phone\NormalizeNumber
     */
    private $normalizeNumber;

    /**
     * @var Phone\ResolveCodeByNumber
     */
    private $resolveCodeByNumber;

    /**
     * @var Voip\CollectProviders
     */
    private $collectProviders;

    /**
     * @var GenerateFake
     */
    private $generateFake;

    /**
     * @var Voip\AddConnection
     */
    private $addConnection;

    /**
     * @param Phone\NormalizeNumber $normalizeNumber
     * @param Phone\ResolveCodeByNumber $resolveCodeByNumber
     * @param Voip\CollectProviders $collectProviders
     * @param GenerateFake $generateFake
     * @param Voip\AddConnection $addConnection
     */
    public function __construct(
        Phone\NormalizeNumber $normalizeNumber,
        Phone\ResolveCodeByNumber $resolveCodeByNumber,
        Voip\CollectProviders $collectProviders,
        GenerateFake $generateFake,
        Voip\AddConnection $addConnection
    ) {
        $this->normalizeNumber = $normalizeNumber;
        $this->resolveCodeByNumber = $resolveCodeByNumber;
        $this->collectProviders = $collectProviders;
        $this->generateFake = $generateFake;
        $this->addConnection = $addConnection;
    }

    /**
     * @param string $phone The phone to get the country
     * @param int $amount
     */
    public function populate(
        string $phone,
        int $amount
    ) {
        try {
            $phone = $this->normalizeNumber->normalize($phone);
        } catch (Phone\InvalidNumberException $e) {
            throw new \LogicException();
        }

        try {
            $country = $this->resolveCodeByNumber->resolve($phone);
        } catch (Phone\InvalidNumberException $e) {
            throw new \LogicException();
        }

        /** @var \Traversable $providers */
        $providers = $this->collectProviders->collect();
        $providers = iterator_to_array($providers);
        /** @var Voip\Provider[] $providers */
        $provider = $providers[rand(0, count($providers) - 1)];

        for ($i = 1; $i <= $amount; $i++) {
            $phone = new Phone($this->generateFake->generatePhoneNumber($country));

            for ($i = 1; $i <= $amount; $i++) {
                try {
                    $this->addConnection->add(
                        $provider,
                        $phone
                    );
                } catch (Voip\Connection\ExistentException $e) {
                }
            }
        }
    }
}