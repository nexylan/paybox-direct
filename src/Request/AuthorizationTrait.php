<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
trait AuthorizationTrait
{
    /**
     * @var string|null
     */
    private $authorization = null;

    /**
     * @param string|null $authorization
     *
     * @return $this
     */
    final public function setAuthorization($authorization = null)
    {
        $this->authorization = $authorization;

        return $this;
    }

    /**
     * @return string|null
     */
    final protected function getAuthorization()
    {
        return $this->authorization;
    }
}
