<?php

namespace Yosmy\Voip;

/**
 * @di\service()
 */
class DelegateImportColdRates implements ImportColdRates
{
    /**
     * @var ColdRate\PurgeCollection
     */
    private $purgeCollection;

    /**
     * @var ImportColdRates[]
     */
    private $importColdRatesServices;

    /**
     * @param ColdRate\PurgeCollection $purgeCollection;
     * @param ImportColdRates[]        $importColdRatesServices
     *
     * @di\arguments({
     *     importColdRatesServices: '#yosmy.voip.import_cold_rates'
     * })
     */
    public function __construct(
        ColdRate\PurgeCollection $purgeCollection,
        array $importColdRatesServices
    ) {
        $this->purgeCollection = $purgeCollection;
        $this->importColdRatesServices = $importColdRatesServices;
    }

    /**
     * {@inheritdoc}
     */
    public function import()
    {
        // Purge to start from scratch
        $this->purgeCollection->purge();

        foreach ($this->importColdRatesServices as $importColdRatesService) {
            $importColdRatesService->import();
        }
    }
}