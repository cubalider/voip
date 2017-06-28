<?php

namespace Yosmy\Voip;

use MongoDB\BSON\Persistable;

class Provider implements Persistable, \JsonSerializable
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $code
     * @param string $name
     */
    public function __construct(
        string $code,
        string $name
    )
    {
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function bsonSerialize()
    {
        return [
            '_id' => $this->code,
            'name' => $this->name,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function bsonUnserialize(array $data)
    {
        $this->code = $data['_id'];
        $this->name = $data['name'];
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'code' => $this->code,
            'name' => $this->name
        ];
    }
}
