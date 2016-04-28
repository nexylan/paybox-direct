<?php

namespace Nexy\PayboxDirect\Response;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class DirectPlusResponse extends AbstractResponse
{
    /**
     * @var string
     */
    private $subscriberRef;

    /**
     * @var string|false False if empty.
     */
    private $bearer;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $parameters)
    {
        parent::__construct($parameters);

        $this->subscriberRef = $parameters['REFABONNE'];
        $this->bearer = $parameters['PORTEUR'];
    }

    /**
     * @return string
     */
    public function getSubscriberRef()
    {
        return $this->subscriberRef;
    }

    /**
     * @return string
     */
    public function getBearer()
    {
        return $this->bearer;
    }
}
