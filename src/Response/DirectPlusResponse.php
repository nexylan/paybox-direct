<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

        $this->subscriberRef = $this->filteredParameters['REFABONNE'];
        $this->bearer = $this->filteredParameters['PORTEUR'];
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
