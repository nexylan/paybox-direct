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
     * @param int $reference
     * @param int $amount
     */
    public function __construct($reference, $amount)
    {
        parent::__construct($amount);

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
