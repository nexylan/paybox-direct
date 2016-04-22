<?php

namespace Nexy\PayboxDirect\Tests\Bundle;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractContainerBuilderTestCase;
use Nexy\PayboxDirect\Bundle\NexyPayboxDirectBundle;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class NexyPayboxDirectBundleTest extends AbstractContainerBuilderTestCase
{
    /**
     * @var NexyPayboxDirectBundle
     */
    private $bundle;

    protected function setUp()
    {
        parent::setUp();

        $this->bundle = new NexyPayboxDirectBundle();
    }

    public function testBuild()
    {
        $this->bundle->build($this->container);
    }
}
