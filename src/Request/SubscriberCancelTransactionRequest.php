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
final class SubscriberCancelTransactionRequest extends AbstractReferencedBearerTransactionRequest
{
    use TransactionNumberTrait, CallNumberTrait;

    /**
     * @param string $subscriberRef
     * @param string $reference
     * @param int    $amount
     * @param string $bearer
     * @param string $validityDate
     * @param int    $transactionNumber
     * @param int    $callNumber
     */
    public function __construct($subscriberRef, $reference, $amount, $bearer, $validityDate, $transactionNumber, $callNumber)
    {
        parent::__construct($reference, $amount, $bearer, $validityDate, $subscriberRef);

        $this->transactionNumber = $transactionNumber;
        $this->callNumber = $callNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestType()
    {
        return RequestInterface::SUBSCRIBER_CANCEL_TRANSACTION;
    }
}
