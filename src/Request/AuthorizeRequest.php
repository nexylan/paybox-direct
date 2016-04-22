<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class AuthorizeRequest extends AbstractReferencedTransactionRequest
{
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
        parent::__construct($reference, $amount);

        $this->cardSerial = $cardSerial;
        $this->cardValidity = $cardValidity;
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
            'PORTEUR' => $this->cardSerial,
            'DATEVAL' => $this->cardValidity,
        ];

        if (null !== $this->cardVerificationValue) {
            $parameters['CVV'] = $this->cardVerificationValue;
        }

        return array_merge(parent::getParameters(), $parameters);
    }
}
