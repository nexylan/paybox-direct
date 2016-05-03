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
trait CallNumberTrait
{
    /**
     * @var int
     *
     * @Assert\Type("int")
     * @Assert\Length(max=10)
     */
    private $callNumber;

    /**
     * @return int
     */
    final protected function getCallNumber()
    {
        return $this->callNumber;
    }
}
