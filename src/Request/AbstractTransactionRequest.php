<?php

namespace Nexy\PayboxDirect\Request;

abstract class AbstractTransactionRequest extends AbstractRequest
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @var int|null
     */
    private $currency = null;

    /**
     * @param int $amount
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @param int $currency
     *
     * @return $this
     */
    final public function setCurrency($currency = null)
    {
        $this->currency = $currency;

        return $this;
    }

    public function getParameters()
    {
        $parameters = [
            'MONTANT' => $this->amount,
            'DEVISE' => $this->currency,
        ];

        return array_merge(parent::getParameters(), $parameters);
    }
}
