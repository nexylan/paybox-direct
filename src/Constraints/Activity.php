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

        // Option to choose to show constant or options
        $this->message = 'The value you selected is not a valid '
            .\Nexy\PayboxDirect\Enum\Activity::class
            .' enum value. Valid constants are: '
            .implode(', ', \Nexy\PayboxDirect\Enum\Activity::getKeys())
            .'.'
        ;
        $this->multipleMessage = 'One or more of the given '
            .\Nexy\PayboxDirect\Enum\Activity::class
            .' enum values is invalid. Valid constants are: '
            .implode(', ', \Nexy\PayboxDirect\Enum\Activity::getKeys())
            .'.'
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return ChoiceValidator::class;
    }
}
