<?php


namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractNumberedTransactionRequest extends AbstractTransactionRequest
{
    use TransactionNumberTrait, CallNumberTrait;

    public function __construct($amount, $transactionNumber, $callNumber)
    {
        parent::__construct($amount);

        $this->transactionNumber = $transactionNumber;
        $this->callNumber = $callNumber;
    }
}
