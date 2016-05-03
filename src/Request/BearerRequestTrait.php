<?php

namespace Nexy\PayboxDirect\Request;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
trait BearerRequestTrait
{
    /**
     * Card number or reference.
     *
     * @var string
     *
     * @Assert\Type("string")
     * @Assert\Length(min=1, max=19)
     */
    private $bearer;

    /**
     * @var string
     *
     * @Assert\Type("string")
     * @Assert\Length(min=4, max=4)
     * @Assert\Regex("/[0-9]+/")
     */
    private $validityDate;

    /**
     * @var string|null
     *
     * @Assert\Type("string")
     * @Assert\Length(min=3, max=4)
     * @Assert\Regex("/[0-9]+/")
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
