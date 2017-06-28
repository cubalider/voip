<?php

namespace Yosmy\Voip;

/**
 * @di\service()
 */
class DelegateImportConnections implements ImportConnections
{
    /**
     * @var ImportConnections[]
     */
    private $importConnectionsServices;

    /**
     * @param ImportConnections[] $importConnectionsServices
     *
     * @di\arguments({
     *     importConnectionsServices: '#yosmy.voip.import_connections'
     * })
     */
    public function __construct(
        array $importConnectionsServices
    )
    {
        $this->importConnectionsServices = $importConnectionsServices;
    }

    /**
     * {@inheritdoc}
     */
    public function import()
    {
        foreach ($this->importConnectionsServices as $importConnectionsService) {
            $importConnectionsService->import();
        }
    }
}