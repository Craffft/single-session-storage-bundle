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

namespace Craffft\SingleSessionStorageBundle\Storage;

use Craffft\SingleSessionStorageBundle\Storage\Exception\SingleSessionNotFoundException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class SingleSessionStorage implements SingleSessionStorageInterface
{
    /**
     * The namespace used to store values in the session.
     *
     * @var string
     */
    const SESSION_NAMESPACE = 'single_session_storage';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var bool
     */
    private $sessionStarted = false;

    /**
     * @var array
     */
    private $session = array();

    /**
     * Initializes the storage with a session namespace.
     *
     * @param ContainerInterface $container
     * @param string $namespace The namespace under which the session is stored
     */
    public function __construct(ContainerInterface $container, $namespace = self::SESSION_NAMESPACE)
    {
        $this->container = $container;
        $this->namespace = $namespace;
    }

    /**
     * Defines an other namespace
     *
     * @param $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        if (!$this->sessionStarted) {
            $this->startSession();
        }

        if (!isset($this->session[$this->namespace][$name])) {
            throw new SingleSessionNotFoundException('The session with name "' . $name . '" does not exist.');
        }

        return (string)$this->session[$this->namespace][$name];
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        if (!$this->sessionStarted) {
            $this->startSession();
        }

        $this->session[$this->namespace][$name] = (string)$value;
        $this->saveSession();
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        if (!$this->sessionStarted) {
            $this->startSession();
        }

        return isset($this->session[$this->namespace][$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($name)
    {
        if (!$this->sessionStarted) {
            $this->startSession();
        }

        $value = isset($this->session[$this->namespace][$name])
            ? (string)$this->session[$this->namespace][$name]
            : null;

        unset($this->session[$this->namespace][$name]);

        $this->saveSession();

        return $value;
    }

    private function startSession()
    {
        $this->loadSession();
        $this->sessionStarted = true;
    }

    public function saveSession()
    {
        $fs = new Filesystem();

        $file = $this->getFilePath();
        $content = Yaml::dump($this->session);
        $fs->dumpFile($file, $content);
    }

    public function cleanSession()
    {
        $this->session = array();

        $fs = new Filesystem();
        $fs->remove($this->getFilePath());
    }

    protected function loadSession()
    {
        $this->session = array();
        $file = $this->getFilePath();

        if (file_exists($file)) {
            $content = Yaml::parse(file_get_contents($file));

            if (is_array($content)) {
                $this->session = $content;
            }
        }
    }

    /**
     * @return string
     */
    protected function getFilePath()
    {
        $fs = new Filesystem();
        $dir = $this->container->getParameter('kernel.cache_dir') . '/storage';

        if (!$fs->exists($dir)) {
            $fs->mkdir($dir);
        }

        return $dir . '/' . $this->namespace . '.yml';
    }
}
