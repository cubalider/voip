<?php

namespace Yosmy\Voip;

use Yosmy\Phone;

interface RateCall
{
    /**
     * @param Connection $connection
     * @param Phone $destination
     *
     * @return HotRate
     *
     * @throws UnsupportedProviderException
     */
    public function rate(
        Connection $connection,
        Phone $destination
    );
}