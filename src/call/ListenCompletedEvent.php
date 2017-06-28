<?php

namespace Yosmy\Voip;

interface ListenCompletedEvent
{
    /**
     * @param string $id
     * @param string $origin
     * @param string $connection
     * @param int    $start
     * @param int    $duration
     * @param string $cost
     * @param string $currency
     */
    public function listen(
        string $id,
        string $origin,
        string $connection,
        int $start,
        int $duration,
        string $cost,
        string $currency
    );
}