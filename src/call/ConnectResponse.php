<?php

namespace Yosmy\Voip;

class ConnectResponse
{
    /**
     * @var string
     */
    private $destination;

    /**
     * Max duration
     *
     * @var int
     */
    private $duration;

    /**
     * @param string   $destination
     * @param int|null $duration
     */
    public function __construct($destination, $duration = null)
    {
        $this->destination = $destination;
        $this->duration = $duration ?: 3600;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }
}