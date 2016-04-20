<?php

namespace Nexy\PayboxDirect\OptionsResolver;

use Symfony\Component\OptionsResolver\OptionsResolver as BaseOptionsResolver;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class OptionsResolver extends BaseOptionsResolver
{
    /**
     * @param string $option
     * @param mixed  $allowedTypes
     *
     * @return $this|BaseOptionsResolver
     */
    public function setAllowedTypesIfDefined($option, $allowedTypes)
    {
        if (!$this->isDefined($option)) {
            return $this;
        }

        return $this->setAllowedTypes($option, $allowedTypes);
    }

    /**
     * @param string $option
     * @param mixed  $allowedValues
     *
     * @return $this|BaseOptionsResolver
     */
    public function setAllowedValuesIfDefined($option, $allowedValues)
    {
        if (!$this->isDefined($option)) {
            return $this;
        }

        return $this->setAllowedValues($option, $allowedValues);
    }
}
