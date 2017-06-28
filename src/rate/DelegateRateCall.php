<?php

namespace Yosmy\Voip;

use Yosmy\Phone;

/**
 * @di\service({
 *     private: true
 * })
 */
class DelegateRateCall implements RateCall
{
    /**
     * @var RateCall[]
     */
    private $rateCallServices;

    /**
     * @di\arguments({
     *     rateCallServices: '#yosmy.voip.rate_call',
     * })
     *
     * @param RateCall[]     $rateCallServices
     */
    public function __construct(
        array $rateCallServices
    ) {
        $this->rateCallServices = $rateCallServices;
    }

    /**
     * {@inheritdoc}
     */
    public function rate(
        Connection $connection,
        Phone $destination
    ) {
        if (!isset($this->rateCallServices[$connection->getProvider()])) {
            throw new UnsupportedProviderException();
        }

        return $this->rateCallServices[$connection->getProvider()]->rate(
            $connection,
            $destination
        );
    }
}