<?php

namespace Yosmy\Voip;

use MongoDB\BSON\Persistable;
use MongoDB\BSON\UTCDateTime;

class RunningCall implements Persistable, \JsonSerializable
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
    private $limit;
    
    /**
     * @var int
     */
    private $start;

    /**
     * @param string $id
     * @param string $provider
     * @param string $cid
     * @param string $origin
     * @param string $connection
     * @param string $destination
     * @param string $limit
     * @param int    $start
     */
    public function __construct(
        $id,
        $provider,
        $cid,
        $origin,
        $connection,
        $destination,
        $limit,
        int $start
    ) {
        $this->id = $id;
        $this->provider = $provider;
        $this->cid = $cid;
        $this->origin = $origin;
        $this->connection = $connection;
        $this->destination = $destination;
        $this->limit = $limit;
        $this->start = $start;
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
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
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
            'limit' => $this->limit,
            'start' => new UTCDateTime($this->start * 1000),
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
        $this->limit = $data['limit'];
        $this->start = $start->toDateTime()->getTimestamp();
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
            'limit' => $this->limit,
            'start' => $this->start,
        ];
    }
}
