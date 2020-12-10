<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Tests;

use Nexy\PayboxDirect\Enum\Activity;
use Nexy\PayboxDirect\Enum\Version;
use Nexy\PayboxDirect\Paybox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class PayboxTest extends TestCase
{
    /**
     * @dataProvider getMissingOptionKeys
     */
    public function testMissingOption($option)
    {
        $this->expectException(MissingOptionsException::class);
        $requiredOptionsData = [
            'paybox_version' => Version::DIRECT_PLUS,
            'paybox_site' => '1999888',
            'paybox_rank' => '32',
            'paybox_identifier' => '107904482',
            'paybox_key' => '1999888I',
        ];

        unset($requiredOptionsData[$option]);

        new Paybox($requiredOptionsData);
    }

    public function getMissingOptionKeys()
    {
        return [
            ['paybox_version'],
            ['paybox_site'],
            ['paybox_rank'],
            ['paybox_identifier'],
            ['paybox_key'],
        ];
    }
}
