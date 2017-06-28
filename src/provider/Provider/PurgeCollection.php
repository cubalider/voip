<?php

namespace Yosmy\Voip\Provider;

/**
 * @di\service()
 */
class PurgeCollection
{
    /**
     * @var SelectCollection
     */
    private $selectCollection;

    /**
     * @param SelectCollection $selectCollection
     */
    public function __construct(SelectCollection $selectCollection)
    {
        $this->selectCollection = $selectCollection;
    }

    public function purge()
    {
        $this->selectCollection->select()->drop();
    }
}
