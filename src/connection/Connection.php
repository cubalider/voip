<?php

namespace Yosmy\Voip;

use MongoDB\BSON\Persistable;

class Connection implements Persistable, \JsonSerializable
{
    /**
     * @var string
     */
    private $provider;
    
    /**
     * @var string
     */
    private $number;

    /**
     * @param string $provider
     * @param string $number
     */
    public function __construct(
        string $provider,
        string $number
    ) {
        $this->provider = $provider;
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * {@inheritdoc}
     */
    public function bsonSerialize()
    {
        return [
            '_id' => $this->number,
            'provider' => $this->provider,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function bsonUnserialize(array $data)
    {
        $this->provider = $data['provider'];
        $this->number = $data['_id'];
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'provider' => $this->provider,
            'number' => $this->number,
        ];
    }
}
