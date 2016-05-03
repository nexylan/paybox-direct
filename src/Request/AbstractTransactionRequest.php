<?php

namespace Nexy\PayboxDirect\Request;

use Greg0ire\Enum\Bridge\Symfony\Validator\Constraint\Enum;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractTransactionRequest extends AbstractRequest
{
    /**
     * @var int
     *
     * @Assert\Type("int")
     */
    private $amount;

    /**
     * @var int|null
     *
     * @Enum(class="Nexy\PayboxDirect\Enum\Currency", showKeys=true)
     */
    private $currency = null;

    /**
     * @param int         $amount
     * @param string|null $subscriberRef
     */
    public function __construct($amount, $subscriberRef = null)
    {
        parent::__construct($subscriberRef);

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
