<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractBearerTransactionRequest extends AbstractTransactionRequest
{
    use BearerRequestTrait;

    /**
     * @param int         $amount
     * @param string      $bearer
     * @param string      $validityDate
     * @param string|null $subscriberRef
     */
    public function __construct($amount, $bearer, $validityDate, $subscriberRef = null)
    {
        parent::__construct($amount, $subscriberRef);

        $this->bearer = $bearer;
        $this->validityDate = $validityDate;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        return array_merge(parent::getParameters(), $this->getBearerParameters());
    }
}
