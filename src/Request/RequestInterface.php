<?php

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
    const AUTHORIZE_SUBSCRIBER = 51;
    const DEBIT_SUBSCRIBER = 52;
    const AUTHORIZE_AND_CAPTURE_SUBSCRIBER = 53;
    const CREDIT_SUBSCRIBER = 54;
    const CANCEL_SUBSCRIBER_TRANSACTION = 55;
    const REGISTER_SUBSCRIBER = 56;
    const UPDATE_SUBSCRIBER = 57;
    const DELETE_SUBSCRIBER = 58;
    const TRANSACT_SUBSCRIBER = 61;

    /**
     * Returns the request ID.
     *
     * Corresponds to the TYPE parameters of PayBox.
     *
     * @return int
     */
    public function getRequestId();

    /**
     * Returns Paybox formatted parameters array.
     *
     * @return array
     */
    public function getParameters();
}
