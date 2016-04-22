<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class AuthorizeRequest extends AbstractRequest
{
    /**
     * @var string
     */
    private $reference;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var int
     */
    private $currency = null;

    /**
     * @var string
     */
    private $cardSerial;

    /**
     * @var string
     */
    private $cardValidity;

    /**
     * @var string
     */
    private $cardVerificationValue = null;

    /**
     * @param string $reference
     * @param int    $amount
     * @param string $cardSerial
     * @param string $cardValidity
     */
    public function __construct($reference, $amount, $cardSerial, $cardValidity)
    {
        $this->reference = $reference;
        $this->amount = $amount;
        $this->cardSerial = $cardSerial;
        $this->cardValidity = $cardValidity;
    }

    /**
     * @param int $currency
     */
    public function setCurrency($currency = null)
    {
        $this->currency = $currency;
    }

    /**
     * @param string|null $cardVerificationValue
     */
    public function setCardVerificationValue($cardVerificationValue = null)
    {
        $this->cardVerificationValue = $cardVerificationValue;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestId()
    {
        return RequestInterface::AUTHORIZE;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        $parameters = [
            'REFERENCE' => $this->reference,
            'MONTANT' => $this->amount,
            'DEVISE' => $this->currency,
            'PORTEUR' => $this->cardSerial,
            'DATEVAL' => $this->cardValidity,
        ];

        if (null !== $this->cardVerificationValue) {
            $parameters['CVV'] = $this->cardVerificationValue;
        }

        return array_merge(parent::getParameters(), $parameters);
    }
}
