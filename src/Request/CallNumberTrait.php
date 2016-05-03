<?php

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
