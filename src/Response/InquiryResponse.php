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
 * Special response for inquiry request.
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class InquiryResponse extends AbstractResponse
{
    /**
     * @var string
     */
    private $status;

    /**
     * @var string|null
     */
    private $discount = null;

    /**
     * {@inheritdoc}
     */
    public function __construct($parameters)
    {
        parent::__construct($parameters);

        $this->status = $this->filteredParameters['STATUS'];

        if (array_key_exists('REMISE', $this->filteredParameters)) {
            $this->discount = $this->filteredParameters['REMISE'];
        }
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getDiscount()
    {
        return $this->discount;
    }
}
