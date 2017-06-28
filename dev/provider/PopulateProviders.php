<?php

namespace Yosmy\Voip\Dev;

use MongoDB\Driver\Exception\BulkWriteException;
use Yosmy\GenerateFake;
use Yosmy\Voip;

/**
 * @di\service()
 */
class PopulateProviders
{
    /**
     * @var Voip\Provider\SelectCollection
     */
    private $selectCollection;

    /**
     * @var GenerateFake
     */
    private $generateFake;

    /**
     * @param Voip\Provider\SelectCollection $selectCollection
     * @param GenerateFake $generateFake
     */
    public function __construct(
        Voip\Provider\SelectCollection $selectCollection,
        GenerateFake $generateFake
    ) {
        $this->selectCollection = $selectCollection;
        $this->generateFake = $generateFake;
    }

    /**
     * @param int $amount
     */
    public function populate($amount)
    {
        for ($i = 1; $i <= $amount; $i++) {
            $provider = $this->generateFake->generateWord();

            try {
                $this->selectCollection->select()->insertOne(new Voip\Provider(
                    $provider,
                    ucfirst($provider)
                ));
            } catch (BulkWriteException $e) {
                $error = $e->getWriteResult()->getWriteErrors()[0];

                // Same fake word?
                if ($error->getCode() == 11000) {
                    $i--;

                    continue;
                }

                throw $e;
            }
        }
    }
}