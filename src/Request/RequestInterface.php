<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
interface RequestInterface
{
    const AUTHORIZE = 1;

    const DEBIT = 2;

    const AUTHORIZE_AND_CAPTURE = 3;

    const CREDIT = 4;

    const CANCEL = 5;

    const CHECK = 11;

    const TRANSACT = 12;

    const UPDATE_AMOUNT = 13;

    const REFUND = 14;

    const INQUIRY = 17;

    const SUBSCRIBER_AUTHORIZE = 51;

    const SUBSCRIBER_DEBIT = 52;

    const SUBSCRIBER_AUTHORIZE_AND_CAPTURE = 53;

    const SUBSCRIBER_CREDIT = 54;

    const SUBSCRIBER_CANCEL_TRANSACTION = 55;

    const SUBSCRIBER_REGISTER = 56;

    const SUBSCRIBER_UPDATE = 57;

    const SUBSCRIBER_DELETE = 58;

    const SUBSCRIBER_TRANSACT = 61;

    /**
     * Returns the request type.
     *
     * Corresponds to the TYPE parameters of PayBox.
     *
     * @return int
     */
    public function getRequestType();

    /**
     * Returns Paybox formatted parameters array.
     *
     * @return array
     */
    public function getParameters();
}
