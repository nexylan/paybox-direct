<?php

namespace Nexy\PayboxDirect\Constraints;

use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\ChoiceValidator;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Activity extends Choice
{
    /**
     * {@inheritdoc}
     */
    public function __construct($options)
    {
        parent::__construct($options);

        $this->choices = \Nexy\PayboxDirect\Enum\Activity::getConstants();
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return ChoiceValidator::class;
    }
}
