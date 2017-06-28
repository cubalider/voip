<?php

namespace Yosmy\Voip;

use Yosmy\Phone\ResolveCodeByCountry;

/**
 * @di\service()
 */
class PickColdRate
{
    /**
     * @var ResolveCodeByCountry
     */
    private $resolveCodeByCountry;

    /**
     * @var ColdRate\SelectCollection
     */
    private $selectCollection;

    /**
     * @param ResolveCodeByCountry  $resolveCodeByCountry
     * @param ColdRate\SelectCollection $selectCollection
     */
    public function __construct(
        ResolveCodeByCountry $resolveCodeByCountry,
        ColdRate\SelectCollection $selectCollection
    ) {
        $this->resolveCodeByCountry = $resolveCodeByCountry;
        $this->selectCollection = $selectCollection;
    }

    /**
     * Resolve rate for given number.
     *
     * @param string $number
     *
     * @return string
     *
     * @throws ColdRate\NonexistentException
     *
     */
    public function pick(string $number)
    {
        $country = $this->resolveCodeByCountry->resolve($number);

        /** @var ColdRate $rate */
        $rate = $this->selectCollection->select()->findOne([
            'code' => (string) $country
        ]);

        if ($rate === null) {
            throw new ColdRate\NonexistentException();
        }

        return $rate->getPrice();
    }
}
