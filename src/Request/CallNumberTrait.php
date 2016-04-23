<?php


namespace Nexy\PayboxDirect\Request;


trait CallNumberTrait
{
    /**
     * @var int
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
