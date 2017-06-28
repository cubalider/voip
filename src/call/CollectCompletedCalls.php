<?php

namespace Yosmy\Voip;

use MongoDB\BSON\UTCDateTime;

/**
 * @di\service()
 */
class CollectCompletedCalls
{
    /**
     * @var CompletedCall\SelectCollection
     */
    private $selectCompletedCallCollection;

    /**
     * @param CompletedCall\SelectCollection $selectCompletedCallCollection
     */
    public function __construct(CompletedCall\SelectCollection $selectCompletedCallCollection)
    {
        $this->selectCompletedCallCollection = $selectCompletedCallCollection;
    }

    /**
     * @param string[]|null $ids
     * @param string|null   $origin
     * @param int|null      $from
     * @param int|null      $to
     * @param int|null      $limit
     *
     * @return CompletedCalls
     */
    public function collect(
        array $ids = null,
        string $origin = null,
        int $from = null,
        int $to = null,
        int $limit = null
    ) {
        $criteria = [];
        $options = [];

        if ($ids !== null) {
            $criteria['_id'] = ['$in' => $ids];
        }

        if ($origin != null) {
            $criteria['origin'] = $origin;
        }

        if ($from != null || $to != null) {
            $start = [];

            if ($from != null) {
                $start['$gte'] = new UTCDateTime($from * 1000);
            }

            if ($to != null) {
                $start['$lt'] = new UTCDateTime($to * 1000);
            }

            $criteria['start'] = $start;
        }

        if (isset($criteria['start'])) {
            $options['sort'] = ['start' => -1];
        }

        if ($limit !== null) {
            $options['limit'] = $limit;
        }


        $cursor = $this->selectCompletedCallCollection->select()->find(
            $criteria,
            $options
        );

        return new CompletedCalls($cursor);
    }
}