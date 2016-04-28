<?php

namespace Nexy\PayboxDirect\Exception;

use Nexy\PayboxDirect\Response\ResponseInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class PayboxException extends \RuntimeException
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * {@inheritdoc}
     */
    public function __construct(ResponseInterface $response, \Exception $previous = null)
    {
        parent::__construct('', $response->getCode(), $previous);

        $this->message = sprintf('%05d: %s', $response->getCode(), $response->getComment());
        $this->response = $response;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
