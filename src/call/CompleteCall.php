<?php

namespace Yosmy\Voip;

/**
 * @di\service()
 */
class CompleteCall
{
    /**
     * @var RunningCall\SelectCollection
     */
    private $selectRunningCallCollection;

    /**
     * @var CompletedCall\SelectCollection
     */
    private $selectCompletedCallCollection;

    /**
     * @var ListenCompletedEvent[]
     */
    private $listenCompletedEventServices;

    /**
     * @param RunningCall\SelectCollection   $selectRunningCallCollection
     * @param CompletedCall\SelectCollection $selectCompletedCallCollection
     * @param ListenCompletedEvent[]         $listenCompletedEventServices
     *
     * @di\arguments({
     *     listenCompletedEventServices: '#yosmy.voip.listen_completed_event'
     * })
     */
    public function __construct(
        RunningCall\SelectCollection $selectRunningCallCollection,
        CompletedCall\SelectCollection $selectCompletedCallCollection,
        array $listenCompletedEventServices
    ) {
        $this->selectRunningCallCollection = $selectRunningCallCollection;
        $this->selectCompletedCallCollection = $selectCompletedCallCollection;
        $this->listenCompletedEventServices = $listenCompletedEventServices;
    }

    /**
     * @param string $provider
     * @param string $cid
     * @param int    $start
     * @param int    $duration
     * @param string $cost
     * @param string $currency
     *
     * @throws RunningCall\NonExistentException
     */
    public function complete(
        string $provider,
        string $cid,
        int $start,
        int $duration,
        string $cost,
        string $currency
    ) {
        /** @var RunningCall $runningCall */
        $runningCall = $this->selectRunningCallCollection->select()->findOne([
            'cid' => $cid,
            'provider' => $provider
        ]);

        if (is_null($runningCall)) {
            throw new RunningCall\NonExistentException();
        }

        $this->selectCompletedCallCollection->select()->insertOne(new CompletedCall(
            $runningCall->getId(),
            $runningCall->getProvider(),
            $runningCall->getCid(),
            $runningCall->getOrigin(),
            $runningCall->getConnection(),
            $runningCall->getDestination(),
            $start,
            $duration,
            $cost,
            $currency
        ));

        $this->selectRunningCallCollection->select()->deleteOne(
            ['_id' => $runningCall->getId()]
        );

        foreach ($this->listenCompletedEventServices as $listenCompletedEventService) {
            $listenCompletedEventService->listen(
                $runningCall->getId(),
                $runningCall->getOrigin(),
                $runningCall->getConnection(),
                $start,
                $duration,
                $cost,
                $currency
            );
        }
    }
}
