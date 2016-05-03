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
trait AuthorizationTrait
{
    /**
     * @var string|null
     *
     * @Assert\Length(min=1, max=10)
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
     * @return bool
     */
    final protected function hasAuthorization()
    {
        return !empty($this->authorization);
    }

    /**
     * @return string|null
     */
    final protected function getAuthorization()
    {
        return $this->authorization;
    }
}
