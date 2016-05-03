<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Enum;

use Greg0ire\Enum\BaseEnum;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Currency extends BaseEnum
{
    const EURO = 978;
    const US_DOLLAR = 840;
    const CFA = 952;
}
