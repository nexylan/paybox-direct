<?php

namespace Nexy\PayboxDirect\Request;

use Nexy\PayboxDirect\Variable\Activity;

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
     * @param int $activity
     *
     * @return $this
     */
    public function setActivity($activity)
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
     */
    public function setShowCountry($showCountry)
    {
        $this->showCountry = $showCountry;
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

        if (true === $this->showCountry) {
            $parameters['PAYS'] = '';
        }

        return $parameters;
    }
}
