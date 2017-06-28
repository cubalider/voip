<?php

namespace Yosmy\Voip;

interface ReceiveEvent
{
    /**
     * @param array $payload
     *
     * @throws UnsupportedEventException
     */
    public function receive($payload);
}