<?php

namespace Yosmy\Voip\Dev;

use Yosmy\Voip;

/**
 * @di\service()
 */
class PurgeRates
{
    /**
     * @var Voip\ColdRate\SelectCollection
     */
    private $selectCollection;

    /**
     * @param Voip\ColdRate\SelectCollection $selectCollection
     */
    public function __construct(Voip\ColdRate\SelectCollection $selectCollection)
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