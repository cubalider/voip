<?php

namespace Yosmy\Voip\Dev;

use Yosmy\Voip;

/**
 * @di\service()
 */
class PurgeConnections
{
    /**
     * @var Voip\Connection\SelectCollection
     */
    private $selectCollection;

    /**
     * @param Voip\Connection\SelectCollection $selectCollection
     */
    public function __construct(Voip\Connection\SelectCollection $selectCollection)
    {
        $this->selectCollection = $selectCollection;
    }

    /**
     *
     */
    public function purge()
    {
        $this->selectCollection->select()->drop();
    }
}