<?php

namespace Yosmy\Voip;

/**
 * @di\service()
 */
class CollectColdRates
{
    /**
     * @var PickConnection
     */
    private $pickConnection;

    /**
     * @var ColdRate\SelectCollection
     */
    private $selectCollection;

    /**
     * @param PickConnection            $pickConnection
     * @param ColdRate\SelectCollection $selectCollection
     */
    public function __construct(
        PickConnection $pickConnection,
        ColdRate\SelectCollection $selectCollection
    )
    {
        $this->pickConnection = $pickConnection;
        $this->selectCollection = $selectCollection;
    }

    /**
     * Collect rates for given number (provider).
     *
     * @param string|null $number
     *
     * @return ColdRates
     *
     * @throws Connection\NonexistentException
     */
    public function collect(
        string $number = null
    ) {
        $criteria = [];

        if ($number !== null) {
            try {
                $connection = $this->pickConnection->pick($number);
            } catch (Connection\NonexistentException $e) {
                throw $e;
            }

            $criteria['provider'] = $connection->getProvider();
        }

        return new ColdRates($this->selectCollection->select()
            ->find($criteria));
    }
}
