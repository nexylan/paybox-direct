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
 * Enum for `ACQUEREUR`.
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Receiver extends BaseEnum
{
    const PAYPAL = 'PAYPAL';
    const EMS = 'EMS';
    const ATOSBE = 'ATOSBE';
    const BCMC = 'BCMC';
    const PSC = 'PSC';
    const FINAREF = 'FINAREF';
    const BUYSTER = 'BUYSTER';
    const ONEY = '34ONEY';
}
