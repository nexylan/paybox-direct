<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Enum\Activity;
use Nexy\PayboxDirect\Enum\Version;
use Nexy\PayboxDirect\Paybox;
use Nexy\PayboxDirect\Request\InquiryRequest;
use Nexy\PayboxDirect\Request\RequestInterface;
use Nexy\PayboxDirect\Response\DirectPlusResponse;
use Nexy\PayboxDirect\Response\DirectResponse;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractPayboxSetupTest extends \PHPUnit_Framework_TestCase
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
            'paybox_default_activity' => Activity::WEB_REQUEST,
        ]);
    }

    /**
     * @param RequestInterface $request
     *
     * @return DirectResponse|DirectPlusResponse
     */
    final protected function payboxRequest(RequestInterface $request)
    {
        if ($request instanceof InquiryRequest) {
            return $this->paybox->sendInquiryRequest($request);
        }
        if ($request->getRequestType() >= RequestInterface::SUBSCRIBER_AUTHORIZE) {
            return $this->paybox->sendDirectPlusRequest($request);
        }

        return $this->paybox->sendDirectRequest($request);
    }

    /**
     * @return string
     */
    protected function getPayboxVersion()
    {
        return Version::DIRECT_PLUS;
    }
}
