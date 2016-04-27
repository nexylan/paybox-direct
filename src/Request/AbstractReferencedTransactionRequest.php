<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractReferencedTransactionRequest extends AbstractTransactionRequest
{
    /**
     * @var string
     */
    private $reference;

    /**
     * @param string      $reference
     * @param int         $amount
     * @param string|null $subscriberRef
     */
    public function __construct($reference, $amount, $subscriberRef = null)
    {
        parent::__construct($amount, $subscriberRef);

        $this->reference = $reference;
    }

    public function getParameters()
    {
        $parameters = [
            'REFERENCE' => $this->reference,
        ];

        return array_merge(parent::getParameters(), $parameters);
    }
}
