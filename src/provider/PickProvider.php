<?php

namespace Yosmy\Voip;

/**
 * @di\service()
 */
class PickProvider
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
     * @param string $code
     *
     * @return Provider
     *
     * @throws Provider\NonexistentException
     */
    public function pick($code)
    {
        /** @var Provider $provider */
        $provider = $this->selectCollection
            ->select()
            ->findOne([
                '_id' => $code
            ]);

        if ($provider === null) {
            throw new Provider\NonexistentException();
        }

        return $provider;
    }
}
