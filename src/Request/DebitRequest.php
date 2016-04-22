<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class DebitRequest extends AbstractReferencedTransactionRequest
{
    /**
     * @var int
     */
    private $transactionNumber;

    /**
     * @var int
     */
    private $callNumber;

    /**
     * @param int $reference
     * @param int $amount
     * @param int $transactionNumber
     * @param int $callNumber
     */
    public function __construct($reference, $amount, $transactionNumber, $callNumber)
    {
        parent::__construct($reference, $amount);

        $this->transactionNumber = $transactionNumber;
        $this->callNumber = $callNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestId()
    {
        return RequestInterface::DEBIT;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        $parameters = [
            'NUMTRANS' => $this->transactionNumber,
            'NUMAPPEL' => $this->callNumber,
        ];

        return array_merge(parent::getParameters(), $parameters);
    }
}
