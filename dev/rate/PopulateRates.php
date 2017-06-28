<?php

namespace Yosmy\Voip\Dev;

use Yosmy\GenerateFake;
use Yosmy\Voip;

/**
 * @di\service()
 */
class PopulateRates
{
    /**
     * @var Voip\CollectProviders
     */
    private $collectProviders;

    /**
     * @var GenerateFake
     */
    private $generateFake;

    /**
     * @var Voip\ColdRate\SelectCollection
     */
    private $selectCollection;

    /**
     * @param Voip\CollectProviders $collectProviders
     * @param GenerateFake $generateFake
     * @param Voip\ColdRate\SelectCollection $selectCollection
     */
    public function __construct(
        Voip\CollectProviders $collectProviders,
        GenerateFake $generateFake,
        Voip\ColdRate\SelectCollection $selectCollection
    ) {
        $this->collectProviders = $collectProviders;
        $this->generateFake = $generateFake;
        $this->selectCollection = $selectCollection;
    }

    /**
     *
     */
    public function populate()
    {
        /** @var \Traversable $providers */
        $providers = $this->collectProviders->collect();
        $providers = iterator_to_array($providers);
        /** @var Voip\Provider $provider */
        $provider = $providers[rand(0, count($providers) - 1)];

        $countries = $this->generateFake->generateCountries(GenerateFake::COUNTRY_CODE_2);
        foreach ($countries as $country) {
            $this->selectCollection->select()->insertOne(new Voip\ColdRate(
                uniqid(),
                $provider->getCode(),
                $country,
                $this->generateFake->generateFloat(2, 0.01, 2)
            ));
        }
    }
}