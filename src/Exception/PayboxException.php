<?php

namespace Nexy\PayboxDirect\Exception;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class PayboxException extends \RuntimeException
{
    /**
     * {@inheritdoc}
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->message = sprintf('%05d: %s', $code, $message);
    }
}
