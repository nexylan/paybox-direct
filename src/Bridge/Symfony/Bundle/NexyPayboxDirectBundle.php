<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
