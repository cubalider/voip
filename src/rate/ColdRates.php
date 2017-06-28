<?php

namespace Yosmy\Voip;

use MongoDB\Driver\Cursor;

class ColdRates implements \IteratorAggregate, \JsonSerializable
{
    /**
     * @var ColdRate[]
     */
    private $rates;

    /**
     * @param Cursor $rates
     */
    public function __construct(Cursor $rates)
    {
        $this->rates = $rates;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->rates;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $rates = [];
        foreach ($this->rates as $rate) {
            $rates[] = $rate->jsonSerialize();
        }

        return $rates;
    }
}
