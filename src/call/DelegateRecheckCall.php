<?php

namespace Yosmy\Voip;

/**
 * @di\service()
 */
class DelegateRecheckCall
{
    /**
     * @var RunningCall\SelectCollection
     */
    private $selectRunningCallCollection;

    /**
     * @var RecheckCall[]
     */
    private $recheckCallServices;

    /**
     * @di\arguments({
     *     recheckCallServices: '#yosmy.voip.recheck_call',
     * })
     *
     * @param RunningCall\SelectCollection $selectRunningCallCollection
     * @param RecheckCall[]                $recheckCallServices
     */
    public function __construct(
        RunningCall\SelectCollection $selectRunningCallCollection,
        array $recheckCallServices
    )
    {
        $this->selectRunningCallCollection = $selectRunningCallCollection;
        $this->recheckCallServices = $recheckCallServices;
    }

    /**
     * @param string $id
     *
     * @throws RunningCall\NonExistentException
     * @throws UnsupportedProviderException
     */
    public function recheck($id)
    {
        /** @var RunningCall $runningCall */
        $runningCall = $this->selectRunningCallCollection->select()->findOne([
            '_id' => $id
        ]);

        if ($runningCall === false) {
            throw new RunningCall\NonExistentException();
        }

        if (!isset($this->recheckCallServices[$runningCall->getProvider()])) {
            throw new UnsupportedProviderException();
        }

        $this->recheckCallServices[$runningCall->getProvider()]->recheck(
            $runningCall->getCid()
        );
    }
}