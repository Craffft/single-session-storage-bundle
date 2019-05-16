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

namespace Tests\Craffft\SingleSessionStorageBundle\Storage\Exception;

use Craffft\SingleSessionStorageBundle\Storage\Exception\SingleSessionNotFoundException;

class SingleSessionNotFoundExceptionTest extends \PHPUnit_Framework_TestCase
{
    protected function createException()
    {
        return new SingleSessionNotFoundException();
    }

    public function testExceptionMessage()
    {
        $exception = new SingleSessionNotFoundException('Single Session not found!');
        $this->assertEquals('Single Session not found!', $exception->getMessage());

        $exception = $this->createException();
        $this->assertEquals('', $exception->getMessage());
    }
}
