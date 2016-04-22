<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
interface RequestInterface
{
    /**
     * Returns the request ID.
     *
     * Corresponds to the TYPE parameters of PayBox.
     *
     * @return int
     */
    public function getRequestId();

    /**
     * Returns Paybox formatted parameters array.
     *
     * @return array
     */
    public function getParameters();
}
