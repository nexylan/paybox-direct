<?php


namespace Nexy\PayboxDirect\Request;


trait TransactionNumberTrait
{
    /**
     * @var int
     */
    private $transactionNumber;

    /**
     * @return int
     */
    final protected function getTransactionNumber()
    {
        return $this->transactionNumber;
    }
}
