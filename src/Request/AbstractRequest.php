<?php

namespace Nexy\PayboxDirect\Request;

use Greg0ire\Enum\Bridge\Symfony\Validator\Constraint\Enum;
use Nexy\PayboxDirect\Enum\Activity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractRequest implements RequestInterface
{
    /**
     * @var int
     *
     * @Assert\NotBlank
     * @Enum(class="Nexy\PayboxDirect\Enum\Activity", showKeys=true)
     */
    private $activity = Activity::WEB_REQUEST;

    /**
     * @var \DateTime
     *
     * @Assert\Type("\DateTime")
     */
    private $date = null;

    /**
     * @var bool
     *
     * @Assert\Type("bool")
     */
    private $showCountry = false;

    /**
     * @var bool
     *
     * @Assert\Type("bool")
     */
    private $showSha1 = false;

    /**
     * @var bool
     *
     * @Assert\Type("bool")
     */
    private $showCardType = false;

    /**
     * @var string|null
     *
     * @Assert\Type("string")
     * @Assert\Length(min=1, max=250)
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
     * @return bool
     */
    final protected function hasSubscriberRef()
    {
        return !empty($this->subscriberRef);
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
        if (method_exists($this, 'hasAuthorization') && $this->hasAuthorization()) {
            $parameters['AUTORISATION'] = $this->getAuthorization();
        }

        // Direct Plus requests special case.
        if ($this->hasSubscriberRef()) {
            $parameters['REFABONNE'] = $this->getSubscriberRef();
        }

        return $parameters;
    }
}
