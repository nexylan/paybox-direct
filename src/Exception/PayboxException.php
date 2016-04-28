<?php

namespace Nexy\PayboxDirect\Exception;

use Nexy\PayboxDirect\Response\ResponseInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class PayboxException extends \RuntimeException
{
    /**
     * {@inheritdoc}
     */
    public function __construct(ResponseInterface $response, \Exception $previous = null)
    {
        parent::__construct('', $response->getCode(), $previous);

        $this->message = sprintf('%05d: %s', $response->getCode(), $response->getComment());
    }
}
