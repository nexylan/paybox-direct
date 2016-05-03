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
 * Requests with card numbers or reference.
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractReferencedBearerTransactionRequest extends AbstractReferencedTransactionRequest
{
    use BearerRequestTrait;

    /**
     * @param string      $reference
     * @param int         $amount
     * @param string      $bearer
     * @param string      $validityDate
     * @param string|null $subscriberRef
     */
    public function __construct($reference, $amount, $bearer, $validityDate, $subscriberRef = null)
    {
        parent::__construct($reference, $amount, $subscriberRef);

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
