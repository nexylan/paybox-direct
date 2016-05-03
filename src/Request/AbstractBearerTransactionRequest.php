<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
