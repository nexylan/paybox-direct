<?php

namespace Nexy\PayboxDirect\Request;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
trait TransactionNumberTrait
{
    /**
     * @var int
     *
     * @Assert\Type("int")
     * @Assert\Length(max=10)
     */
    private $transactionNumber;

    /**
     * @return int
     */
    final protected function getTransactionNumber()
    {
        return $this->transactionNumber;
    }
}
