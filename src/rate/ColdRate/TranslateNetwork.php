<?php

namespace Yosmy\Voip\ColdRate;

/**
 * @di\service()
 */
class TranslateNetwork
{
    /**
     * @param string $network
     *
     * @return string
     */
    public function translate($network)
    {
        return str_replace(
            ['Landline', 'Fixed', 'Mobile', 'Other'],
            ['Fijo',     'Fijo',  'Móvil',  'Otro'],
            $network
        );
    }
}
