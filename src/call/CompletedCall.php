<?php

namespace Yosmy\Voip;

use MongoDB\BSON\Persistable;
use MongoDB\BSON\UTCDateTime;

class CompletedCall implements Persistable, \JsonSerializable
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
     * @var string The original call id
     */
    private $cid;

    /**
     * @var string
     */
    private $origin;

    /**
     * @var string
     */
    private $connection;

    /**
     * @var string
     */
    private $destination;

    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $duration;

    /**
     * @var float
     */
    private $cost;

    /**
     * @var string
     */
    private $currency;

    /**
     * @param string $id
     * @param string $provider
     * @param string $cid
     * @param string $origin
     * @param string $connection
     * @param string $destination
     * @param int    $start
     * @param int    $duration
     * @param float  $cost
     * @param string $currency
     */
    public function __construct(
        $id,
        $provider,
        $cid,
        $origin,
        $connection,
        $destination,
        $start,
        $duration,
        $cost,
        $currency
    ) {
        $this->id = $id;
        $this->provider = $provider;
        $this->cid = $cid;
        $this->origin = $origin;
        $this->connection = $connection;
        $this->destination = $destination;
        $this->start = $start;
        $this->duration = $duration;
        $this->cost = $cost;
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
    public function getCid(): string
    {
        return $this->cid;
    }

    /**
     * @return string
     */
    public function getOrigin(): string
    {
        return $this->origin;
    }

    /**
     * @return string
     */
    public function getConnection(): string
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return float
     */
    public function getCost(): float
    {
        return $this->cost;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * {@inheritdoc}
     */
    public function bsonSerialize()
    {
        return [
            '_id' => $this->id,
            'provider' => $this->provider,
            'cid' => $this->cid,
            'origin' => $this->origin,
            'connection' => $this->connection,
            'destination' => $this->destination,
            'start' => new UTCDateTime($this->start * 1000),
            'duration' => $this->duration,
            'cost' => $this->cost,
            'currency' => $this->currency,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function bsonUnserialize(array $data)
    {
        /** @var UTCDateTime $start */
        $start = $data['start'];

        $this->id = $data['_id'];
        $this->provider = $data['provider'];
        $this->cid = $data['cid'];
        $this->origin = $data['origin'];
        $this->connection = $data['connection'];
        $this->destination = $data['destination'];
        $this->start = $start->toDateTime()->getTimestamp();
        $this->duration = $data['duration'];
        $this->cost = $data['cost'];
        $this->currency = $data['currency'];
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'provider' => $this->provider,
            'cid' => $this->cid,
            'origin' => $this->origin,
            'connection' => $this->connection,
            'destination' => $this->destination,
            'start' => $this->start,
            'duration' => $this->duration,
            'cost' => $this->cost,
            'currency' => $this->currency,
        ];
    }
}
