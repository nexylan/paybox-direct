<?php

namespace Nexy\PayboxDirect\Enum;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Currency
{
    const EURO = 978;
    const US_DOLLAR = 840;
    const CFA = 952;

    const ALL = [
        'euro' => self::EURO,
        'us_dollar' => self::US_DOLLAR,
        'cfa' => self::CFA,
    ];
}
