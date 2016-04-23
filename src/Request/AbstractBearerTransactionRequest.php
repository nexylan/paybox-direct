<?php

namespace Nexy\PayboxDirect\Request;

/**
 * Requests with card numbers or reference.
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractBearerTransactionRequest extends AbstractReferencedTransactionRequest
{
    /**
     * Card number or reference.
     *
     * @var string
     */
    private $bearer;

    /**
     * @var string
     */
    private $validityDate;

    /**
     * @var string|null
     */
    private $cardVerificationValue = null;

    /**
     * @param int $reference
     * @param int $amount
     * @param string $bearer
     * @param string $validityDate
     */
    public function __construct($reference, $amount, $bearer, $validityDate)
    {
        parent::__construct($reference, $amount);

        $this->bearer = $bearer;
        $this->validityDate = $validityDate;
    }

    /**
     * @param string|null $cardVerificationValue
     *
     * @return $this
     */
    public function setCardVerificationValue($cardVerificationValue = null)
    {
        $this->cardVerificationValue = $cardVerificationValue;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        $parameters = [
            'PORTEUR' => $this->bearer,
            'DATEVAL' => $this->validityDate,
        ];

        if (null !== $this->cardVerificationValue) {
            $parameters['CVV'] = $this->cardVerificationValue;
        }

        return array_merge(parent::getParameters(), $parameters);
    }
}
