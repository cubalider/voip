<?php

namespace Yosmy\Voip;

use MongoDB\BSON\Persistable;

class ColdRate implements Rate, Persistable, \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $provider;

    /**
     * @var string
     */
    private $country;

    /**
     * @var float
     */
    private $price;

    /**
     * @param string $id
     * @param string $provider
     * @param string $country
     * @param float  $price
     */
    public function __construct(
        $id,
        $provider,
        $country,
        $price
    )
    {
        $this->id = $id;
        $this->provider = $provider;
        $this->country = $country;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * {@inheritdoc}
     */
    public function bsonSerialize()
    {
        return [
            '_id' => $this->id,
            'provider' => $this->provider,
            'country' => $this->country,
            'price' => $this->price,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function bsonUnserialize(array $data)
    {
        $this->id = $data['_id'];
        $this->provider = $data['provider'];
        $this->country = $data['country'];
        $this->price = $data['price'];
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'provider' => $this->provider,
            'country' => $this->country,
            'price' => $this->price,
        ];
    }
}
