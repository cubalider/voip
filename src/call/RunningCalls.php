<?php

namespace Yosmy\Voip;

use MongoDB\Driver\Cursor;

class RunningCalls implements \IteratorAggregate, \JsonSerializable
{
    /**
     * @var RunningCall[]
     */
    private $runningCalls;

    /**
     * @param Cursor $runningCalls
     */
    public function __construct(Cursor $runningCalls)
    {
        $this->runningCalls = $runningCalls;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->runningCalls;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $runningCalls = [];
        foreach ($this->runningCalls as $runningCall) {
            $runningCalls[] = $runningCall->jsonSerialize();
        }

        return $runningCalls;
    }
}
