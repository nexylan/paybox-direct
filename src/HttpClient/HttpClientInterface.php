<?php

namespace Nexy\PayboxDirect\HttpClient;

use Nexy\PayboxDirect\Response\PayboxResponse;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @see http://www1.paybox.com/espace-integrateur-documentation/les-solutions-paybox-direct-et-paybox-direct-plus/
 */
interface HttpClientInterface
{
    /**
     * Init and setup http client with PayboxDirectPlus SDK options.
     */
    public function init();

    /**
     * Calls PayBox Direct platform with given operation type and parameters.
     *
     * @param string   $type       Request type
     * @param string[] $parameters Request parameters
     *
     * @return PayboxResponse The response content
     */
    public function call($type, array $parameters);
}
