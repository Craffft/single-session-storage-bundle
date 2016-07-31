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

namespace Tests\Craffft\SingleSessionStorageBundle\Storage;

use Craffft\SingleSessionStorageBundle\Storage\Exception\SingleSessionNotFoundException;
use Craffft\SingleSessionStorageBundle\Storage\SingleSessionStorage;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;

class SingleSessionStorageTest extends WebTestCase
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var string
     */
    private $filepath;

    /**
     * @var SingleSessionStorage
     */
    private $singleSessionStorage;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->filepath = $this->container->getParameter('kernel.cache_dir') . '/storage/single_session_storage.yml';

        $this->singleSessionStorage = new SingleSessionStorage($this->container);
        $this->singleSessionStorage->cleanSession();
    }

    public function testGetException()
    {
        try {
            $this->singleSessionStorage->get('test');
        } catch (SingleSessionNotFoundException $e) {
            $this->assertEquals($e->getMessage(), 'The session with name "test" does not exist.');

            return;
        }

        $this->fail("Expected Exception has not been raised.");
    }

    public function testGet()
    {
        $this->singleSessionStorage->set('test', 'testValue');
        $this->assertContains('testValue', $this->singleSessionStorage->get('test'));
    }

    public function testHas()
    {
        $this->singleSessionStorage->set('test', 'testValue');

        $this->assertTrue($this->singleSessionStorage->has('test'));
        $this->assertFalse($this->singleSessionStorage->has('notDefined'));
    }

    public function testRemove()
    {
        $this->singleSessionStorage->set('test', 'testValue');

        $this->assertNull($this->singleSessionStorage->remove('notDefined'));

        $this->assertContains('testValue', $this->singleSessionStorage->remove('test'));
        $this->assertNull($this->singleSessionStorage->remove('test'));
    }

    public function testClean()
    {
        $this->singleSessionStorage->set('test', 'testValue');

        $this->assertTrue($this->singleSessionStorage->has('test'));

        $this->singleSessionStorage->cleanSession();

        $this->assertFalse($this->singleSessionStorage->has('test'));
        $this->assertFalse(file_exists($this->filepath));
    }

    public function testSave()
    {
        $this->assertFalse(file_exists($this->filepath));

        $this->singleSessionStorage->set('test', 'testValue');
        $this->singleSessionStorage->saveSession();

        $this->assertTrue(file_exists($this->filepath));
    }
}
