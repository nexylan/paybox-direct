<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractNumberedReferencedTransactionRequest extends AbstractReferencedTransactionRequest
{
    use TransactionNumberTrait, CallNumberTrait;

    public function __construct($reference, $amount, $transactionNumber, $callNumber, $subscriberRef = null)
    {
        parent::__construct($reference, $amount, $subscriberRef);

        $this->transactionNumber = $transactionNumber;
        $this->callNumber = $callNumber;
    }
}
