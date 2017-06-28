<?php

namespace Yosmy\Voip;

use MongoDB\Driver\Exception\BulkWriteException;
use Yosmy\Phone;

/**
 * @di\service()
 */
class AddConnection
{
    /**
     * @var Connection\SelectCollection
     */
    private $selectCollection;

    /**
     * @param Connection\SelectCollection $selectCollection
     */
    public function __construct(
        Connection\SelectCollection $selectCollection
    ) {
        $this->selectCollection = $selectCollection;
    }

    /**
     * @param Provider $provider
     * @param Phone $phone
     *
     * @throws Connection\ExistentException
     */
    public function add(
        Provider $provider,
        Phone $phone
    ) {
        $connection = new Connection(
            $provider->getCode(),
            $phone->getNumber()
        );

        try {
            $this->selectCollection->select()->insertOne($connection);
        } catch (BulkWriteException $e) {
            $error = $e->getWriteResult()->getWriteErrors()[0];

            if ($error->getCode() == 11000) {
                if (strpos($error->getMessage(), 'index: _id_') !== false) {
                    throw new Connection\ExistentException();
                }
            }

            throw $e;
        }
    }
}