<?php

namespace Yosmy\Voip;

use MongoDB\Driver\Cursor;

class Connections implements \IteratorAggregate, \JsonSerializable
{
    /**
     * @var Connection[]
     */
    private $connections;

    /**
     * @param Cursor $connections
     */
    public function __construct(Cursor $connections)
    {
        $this->connections = $connections;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->connections;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $connections = [];
        foreach ($this->connections as $connection) {
            $connections[] = $connection->jsonSerialize();
        }

        return $connections;
    }
}
