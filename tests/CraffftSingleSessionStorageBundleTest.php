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
use PHPUnit\Framework\TestCase;

class CraffftSingleSessionStorageBundleTest extends TestCase
{
    public function testInstantiation()
    {
        $bundle = new CraffftSingleSessionStorageBundle();
        $this->assertInstanceOf('Craffft\SingleSessionStorageBundle\CraffftSingleSessionStorageBundle', $bundle);
    }
}
