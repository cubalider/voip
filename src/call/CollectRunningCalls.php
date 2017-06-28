<?php

namespace Yosmy\Voip;

/**
 * @di\service()
 */
class CollectRunningCalls
{
    /**
     * @var RunningCall\SelectCollection
     */
    private $selectCollection;

    /**
     * @param RunningCall\SelectCollection $selectCollection
     */
    public function __construct(RunningCall\SelectCollection $selectCollection)
    {
        $this->selectCollection = $selectCollection;
    }

    /**
     * @param string $origin
     * @param string $connection
     *
     * @return RunningCalls
     */
    public function collect(string $origin, string $connection)
    {
        $cursor = $this->selectCollection->select()->find([
            'origin' => $origin,
            'connection' => $connection,
        ]);

        return new RunningCalls($cursor);
    }
}