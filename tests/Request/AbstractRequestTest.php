<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Paybox;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Paybox
     */
    protected $paybox;

    protected function setUp()
    {
        $this->paybox = new Paybox([
            'paybox_version' => $this->getPayboxVersion(),
            'paybox_site' => '1999888',
            'paybox_rank' => '32',
            'paybox_identifier' => '107904482',
            'paybox_key' => '1999888I',
        ]);
    }

    /**
     * @return string
     */
    protected function getPayboxVersion()
    {
        return Paybox::VERSION_DIRECT_PLUS;
    }

    /**
     * @return string
     */
    final protected function generateReference()
    {
        $requestClassTab = explode('\\', get_class($this));
        $requestName = strtolower(str_replace('RequestTest', '', end($requestClassTab)));

        return uniqid('nexy_paybox_direct_'.$requestName.'_');
    }
}
