<?php

namespace Yosmy\Voip\Dev;

use Yosmy\Voip;

/**
 * @di\service()
 */
class PurgeProviders
{
    /**
     * @var Voip\Provider\SelectCollection
     */
    private $selectCollection;

    /**
     * @param Voip\Provider\SelectCollection $selectCollection
     */
    public function __construct(Voip\Provider\SelectCollection $selectCollection)
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