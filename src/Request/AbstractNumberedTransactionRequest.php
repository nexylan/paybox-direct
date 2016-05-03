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
abstract class AbstractNumberedTransactionRequest extends AbstractTransactionRequest
{
    use TransactionNumberTrait, CallNumberTrait;

    public function __construct($amount, $transactionNumber, $callNumber)
    {
        parent::__construct($amount);

        $this->transactionNumber = $transactionNumber;
        $this->callNumber = $callNumber;
    }
}
