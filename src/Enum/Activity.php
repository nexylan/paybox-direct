<?php

namespace Nexy\PayboxDirect\Enum;

use Greg0ire\Enum\BaseEnum;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Activity extends BaseEnum
{
    const NOT_SPECIFIED = 20;
    const PHONE_REQUEST = 21;
    const MAIL_REQUEST = 22;
    const MINITEL_REQUEST = 23;
    const WEB_REQUEST = 24;
    const RECURRING_PAYMENT = 27;
}
