<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class AuthorizeRequest implements RequestInterface
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
    private $cardVerificationValue;

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
     * @param string $cardVerificationValue
     */
    public function setCardVerificationValue($cardVerificationValue)
    {
        $this->cardVerificationValue = $cardVerificationValue;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestId()
    {
        return 1;
    }

    /**
     * Returns Paybox formatted parameters array.
     *
     * @return array
     */
    public function getParameters()
    {
        return [];
    }
}
