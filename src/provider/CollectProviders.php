<?php

namespace Yosmy\Voip;

/**
 * @di\service()
 */
class CollectProviders
{
    /**
     * @var Provider\SelectCollection
     */
    private $selectCollection;

    /**
     * @param Provider\SelectCollection $selectCollection
     */
    public function __construct(Provider\SelectCollection $selectCollection)
    {
        $this->selectCollection = $selectCollection;
    }

    /**
     * @return Provider[]
     */
    public function collect()
    {
        /** @var Provider[] $providers */
        $providers = $this->selectCollection->select()->find();

        return $providers;
    }
}