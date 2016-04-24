<?php

namespace Nexy\PayboxDirect\Request;

trait BearerRequestTrait
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
     * @return array
     */
    private function getBearerParameters()
    {
        $parameters = [
            'PORTEUR' => $this->bearer,
            'DATEVAL' => $this->validityDate,
        ];

        if (null !== $this->cardVerificationValue) {
            $parameters['CVV'] = $this->cardVerificationValue;
        }

        return $parameters;
    }
}
