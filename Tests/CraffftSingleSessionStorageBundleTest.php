<?php

/*
 * This file is part of the Craffft Single Session Storage Bundle.
 *
 * (c) Craffft <https://craffft.de>
 * (c) Daniel Kiesel <https://github.com/iCodr8>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Craffft\SingleSessionStorageBundle;

use Craffft\SingleSessionStorageBundle\CraffftSingleSessionStorageBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CraffftSingleSessionStorageBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiation()
    {
        $bundle = new SingleSessionStorageBundle();
        $this->assertInstanceOf('Craffft\SingleSessionStorageBundle\CraffftSingleSessionStorageBundle', $bundle);
    }
}
