<?php

namespace Yosmy\Voip;

use MongoDB\Driver\Exception\BulkWriteException;

/**
 * @di\service()
 */
class AddProvider
{
    /**
     * @var Provider\SelectCollection
     */
    private $selectCollection;

    /**
     * @param Provider\SelectCollection $selectCollection
     */
    public function __construct(
        Provider\SelectCollection $selectCollection
    ) {
        $this->selectCollection = $selectCollection;
    }

    /**
     * @param string $code
     * @param string $name
     *
     * @throws Provider\ExistentException
     */
    public function add(
        string $code,
        string $name
    ) {
        $provider = new Provider(
            $code,
            $name
        );

        try {
            $this->selectCollection->select()->insertOne($provider);
        } catch (BulkWriteException $e) {
            $error = $e->getWriteResult()->getWriteErrors()[0];

            if ($error->getCode() == 11000) {
                if (strpos($error->getMessage(), 'index: _id_') !== false) {
                    throw new Provider\ExistentException();
                }
            }

            throw $e;
        }
    }
}