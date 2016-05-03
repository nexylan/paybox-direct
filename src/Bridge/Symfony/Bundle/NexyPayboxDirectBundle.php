<?php

namespace Nexy\PayboxDirect\Bridge\Symfony\Bundle;

use Nexy\PayboxDirect\Bridge\Symfony\DependencyInjection\NexyPayboxDirectExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class NexyPayboxDirectBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensionClass()
    {
        return NexyPayboxDirectExtension::class;
    }
}
