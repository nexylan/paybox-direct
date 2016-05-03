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

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractReferencedTransactionRequest extends AbstractTransactionRequest
{
    /**
     * @var string
     *
     * @Assert\Type("string")
     * @Assert\Length(min=1, max=250)
     */
    private $reference;

    /**
     * @param string      $reference
     * @param int         $amount
     * @param string|null $subscriberRef
     */
    public function __construct($reference, $amount, $subscriberRef = null)
    {
        parent::__construct($amount, $subscriberRef);

        $this->reference = $reference;
    }

    public function getParameters()
    {
        $parameters = [
            'REFERENCE' => $this->reference,
        ];

        return array_merge(parent::getParameters(), $parameters);
    }
}
