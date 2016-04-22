<?php

namespace Nexy\PayboxDirect\Request;

use Nexy\PayboxDirect\Variable\PayboxVariableActivity;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractRequest implements RequestInterface
{
    /**
     * @var int
     */
    private $activity = PayboxVariableActivity::WEB_REQUEST;

    /**
     * @var \DateTime
     */
    private $date = null;

    /**
     * @param int $activity
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
    }

    /**
     * @param \DateTime|null $date
     */
    final public function setDate(\DateTime $date = null)
    {
        $this->date = $date;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        return [
            'ACTIVITE' => $this->activity,
            'DATEQ' => $this->date instanceof \DateTime ? $this->date->format('dmYHis') : null,
        ];
    }
}
