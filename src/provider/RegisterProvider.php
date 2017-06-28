<?php

namespace Yosmy\Voip;

interface RegisterProvider
{
    /**
     * @return Provider
     */
    public function register();
}