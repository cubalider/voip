<?php

namespace Yosmy\Voip;

class HotRate implements Rate
{
    /**
     * @var float
     */
    private $price;

    /**
     * @param float $price
     */
    public function __construct(float $price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
