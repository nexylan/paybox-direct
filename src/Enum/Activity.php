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

use Greg0ire\Enum\AbstractEnum;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Activity extends AbstractEnum
{
    const NOT_SPECIFIED = 20;

    const PHONE_REQUEST = 21;

    const MAIL_REQUEST = 22;

    const MINITEL_REQUEST = 23;

    const WEB_REQUEST = 24;

    const RECURRING_PAYMENT = 27;
}
