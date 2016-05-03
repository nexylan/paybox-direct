<?php

namespace Nexy\PayboxDirect\Tests\Symfony\Bridge\Bundle;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractContainerBuilderTestCase;
use Nexy\PayboxDirect\Bridge\Symfony\Bundle\NexyPayboxDirectBundle;
use Nexy\PayboxDirect\Bridge\Symfony\DependencyInjection\NexyPayboxDirectExtension;

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

    public function testGetContainerExtension()
    {
        $this->assertInstanceOf(NexyPayboxDirectExtension::class, $this->bundle->getContainerExtension());
    }
}
