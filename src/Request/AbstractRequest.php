<?php

namespace Nexy\PayboxDirect\Request;

use Nexy\PayboxDirect\Enum\Activity;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractRequest implements RequestInterface
{
    /**
     * @var int
     */
    private $activity = Activity::WEB_REQUEST;

    /**
     * @var \DateTime
     */
    private $date = null;

    /**
     * @var bool
     */
    private $showCountry = false;

    /**
     * @var bool
     */
    private $showSha1 = false;

    /**
     * @var bool
     */
    private $showCardType = false;

    /**
     * @var string|null
     */
    private $subscriberRef = null;

    /**
     * @param null|string $subscriberRef
     */
    public function __construct($subscriberRef = null)
    {
        $this->subscriberRef = $subscriberRef;
    }

    /**
     * @param int $activity
     *
     * @return $this
     */
    final public function setActivity($activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * @param \DateTime|null $date
     *
     * @return $this
     */
    final public function setDate(\DateTime $date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @param bool $showCountry
     *
     * @return $this
     */
    final public function setShowCountry($showCountry)
    {
        $this->showCountry = $showCountry;

        return $this;
    }

    /**
     * @param bool $showSha1
     *
     * @return $this
     */
    final public function setShowSha1($showSha1)
    {
        $this->showSha1 = $showSha1;

        return $this;
    }

    /**
     * @param bool $showCardType
     *
     * @return $this
     */
    final public function setShowCardType($showCardType)
    {
        $this->showCardType = $showCardType;

        return $this;
    }

    /**
     * @return null|string
     */
    final protected function getSubscriberRef()
    {
        return $this->subscriberRef;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        $parameters = [
            'ACTIVITE' => $this->activity,
            'DATEQ' => $this->date instanceof \DateTime ? $this->date->format('dmYHis') : null,
        ];

        if ($this->showCountry) {
            $parameters['PAYS'] = '';
        }
        if ($this->showSha1) {
            $parameters['SHA-1'] = '';
        }
        if ($this->showCardType) {
            $parameters['TYPECARTE'] = '';
        }

        if (method_exists($this, 'getTransactionNumber')) {
            $parameters['NUMTRANS'] = $this->getTransactionNumber();
        }
        if (method_exists($this, 'getCallNumber')) {
            $parameters['NUMAPPEL'] = $this->getCallNumber();
        }

        // Direct Plus requests special case.
        if (null !== $this->getSubscriberRef()) {
            $parameters['REFABONNE'] = $this->getSubscriberRef();
        }

        return $parameters;
    }
}
