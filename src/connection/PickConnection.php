<?php

namespace Yosmy\Voip;

/**
 * @di\service({
 *     private: true
 * })
 */
class PickConnection
{
    /**
     * @var Connection\SelectCollection
     */
    private $selectCollection;

    /**
     * @param Connection\SelectCollection $selectCollection
     */
    public function __construct(Connection\SelectCollection $selectCollection)
    {
        $this->selectCollection = $selectCollection;
    }

    /**
     * @param string $number
     *
     * @return Connection
     *
     * @throws Connection\NonexistentException
     */
    public function pick($number)
    {
        /** @var Connection $connection */
        $connection = $this->selectCollection
            ->select()
            ->findOne([
                '_id' => $number
            ]);

        if ($connection === null) {
            throw new Connection\NonexistentException();
        }

        return $connection;
    }
}
