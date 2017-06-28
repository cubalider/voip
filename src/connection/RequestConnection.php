<?php

namespace Yosmy\Voip;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Yosmy\Voip\Connection\InvalidNumberException;

/**
 * @di\service()
 */
class RequestConnection
{
    /**
     * @var Connection\SelectCollection
     */
    private $selectCollection;

    /**
     * @var PhoneNumberUtil
     */
    private $phoneNumberUtil;

    /**
     * @param Connection\SelectCollection $selectCollection
     */
    public function __construct(Connection\SelectCollection $selectCollection)
    {
        $this->selectCollection = $selectCollection;
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
    }

    /**
     * @param string        $number
     * @param string[]|null $exclude
     *
     * @return Connection
     *
     * @throws InvalidNumberException
     * @throws Connection\SoldOutException
     */
    public function request(
        string $number,
        array $exclude = null
    ) {
        $criteria = [];

        if ($exclude !== null) {
            $criteria['_id'] = ['$nin' => $exclude];
        }

        /** @var Connections $connections */
        $connections = $this->selectCollection
            ->select()
            ->find($criteria);

        try {
            $numberCountry = $this->phoneNumberUtil
                ->parse($number, null)
                ->getCountryCode();
        } catch (NumberParseException $e) {
            throw new InvalidNumberException();
        }

        foreach ($connections as $connection) {
            try {
                $connectionCountry = $this->phoneNumberUtil
                    ->parse($connection->getNumber(), null)
                    ->getCountryCode();
            } catch (NumberParseException $e) {
                throw new \LogicException();
            }

            if ($connectionCountry == $numberCountry) {
                return $connection;
            }
        }

        throw new Connection\SoldOutException();
    }
}
