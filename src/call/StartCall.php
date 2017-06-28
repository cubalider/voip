<?php

namespace Yosmy\Voip;

use Yosmy\Phone;

/**
 * @di\service({
 *     private: true
 * })
 */
class StartCall
{
    /**
     * @var RunningCall\SelectCollection
     */
    private $selectRunningCallCollection;

    /**
     * @var Phone\NormalizeNumber
     */
    private $normalizeNumber;

    /**
     * @var ListenIncomingCallEvent[]
     */
    private $listenIncomingCallEventServices;

    /**
     * @param RunningCall\SelectCollection $selectRunningCallCollection
     * @param Phone\NormalizeNumber        $normalizeNumber
     * @param ListenIncomingCallEvent[]    $listenIncomingCallEventServices
     *
     * @di\arguments({
     *     listenIncomingCallEventServices: '#yosmy.voip.listen_incoming_call_event',
     * })
     */
    public function __construct(
        RunningCall\SelectCollection $selectRunningCallCollection,
        Phone\NormalizeNumber $normalizeNumber,
        array $listenIncomingCallEventServices
    ) {
        $this->selectRunningCallCollection = $selectRunningCallCollection;
        $this->normalizeNumber = $normalizeNumber;
        $this->listenIncomingCallEventServices = $listenIncomingCallEventServices;
    }

    /**
     * @param string $provider
     * @param string $cid
     * @param string $origin
     * @param string $connection
     *
     * @return ConnectResponse|HangupResponse
     *
     * @throws Phone\InvalidNumberException
     */
    public function start(
        string $provider,
        string $cid,
        string $origin,
        string $connection
    ) {
        $id = uniqid();

        try {
            $origin = $this->normalizeNumber->normalize($origin);
        } catch (Phone\InvalidNumberException $e) {
            throw $e;
        }

        try {
            $connection = $this->normalizeNumber->normalize($connection);
        } catch (Phone\InvalidNumberException $e) {
            throw $e;
        }

        $response = $this->callListeners(
            $id,
            $origin->getNumber(),
            $connection->getNumber()
        );

        // Is a connect response? then create a running call
        if ($response instanceof ConnectResponse) {
            $this->selectRunningCallCollection->select()->insertOne(new RunningCall(
                $id,
                $provider,
                $cid,
                $origin->getNumber(),
                $connection->getNumber(),
                $response->getDestination(),
                $response->getDuration(),
                time()
            ));
        }

        return $response;
    }

    /**
     * @param string $id
     * @param string $origin
     * @param string $connection
     *
     * @return ConnectResponse|HangupResponse
     */
    private function callListeners(
        string $id,
        string $origin,
        string $connection
    ) {
        foreach ($this->listenIncomingCallEventServices as $listenIncomingCallEventService) {
            $response = $listenIncomingCallEventService->listen(
                $id,
                $origin,
                $connection
            );

            if (
                $response instanceof ConnectResponse
                || $response instanceof HangupResponse
            ) {
                return $response;
            }
        }

        return new HangupResponse();
    }

}