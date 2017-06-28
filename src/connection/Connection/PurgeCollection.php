<?php

namespace Yosmy\Voip\Connection;

/**
 * @di\service()
 */
class PurgeCollection
{
    /**
     * @var SelectCollection
     */
    private $selectConnectionCollection;

    /**
     * @param SelectCollection $selectConnectionCollection
     */
    public function __construct(SelectCollection $selectConnectionCollection)
    {
        $this->selectConnectionCollection = $selectConnectionCollection;
    }

    public function purge()
    {
        $this->selectConnectionCollection->select()->drop();
    }
}
