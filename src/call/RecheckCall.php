<?php

namespace Yosmy\Voip;

interface RecheckCall
{
    /**
     * @param string $id
     *
     * @throws RunningCall\NonExistentException
     * @throws UnsupportedProviderException
     */
    public function recheck($id);
}