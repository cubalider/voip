<?php

namespace Yosmy\Voip;

interface ListenIncomingCallEvent
{
    /**
     * @param string $id         The internal call id, not the provider call id
     * @param string $origin     The phone number the call is coming from
     * @param string $connection The virtual number the call is going to
     *
     * @return ConnectResponse|HangupResponse|null Returns null if the service
     *                                             does not have a response.
     */
    public function listen(
        string $id,
        string $origin,
        string $connection
    );
}