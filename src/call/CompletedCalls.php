<?php

namespace Yosmy\Voip;

use MongoDB\Driver\Cursor;

class CompletedCalls implements \IteratorAggregate, \JsonSerializable
{
    /**
     * @var CompletedCall[]
     */
    private $completedCalls;

    /**
     * @param Cursor $completedCalls
     */
    public function __construct(Cursor $completedCalls)
    {
        $this->completedCalls = $completedCalls;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->completedCalls;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $completedCalls = [];
        foreach ($this->completedCalls as $completedCall) {
            $completedCalls[] = $completedCall->jsonSerialize();
        }

        return $completedCalls;
    }
}
