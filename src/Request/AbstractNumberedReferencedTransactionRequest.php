<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractNumberedReferencedTransactionRequest extends AbstractReferencedTransactionRequest
{
    use TransactionNumberTrait, CallNumberTrait;

    public function __construct($reference, $amount, $transactionNumber, $callNumber)
    {
        parent::__construct($reference, $amount);

        $this->transactionNumber = $transactionNumber;
        $this->callNumber = $callNumber;
    }
}
