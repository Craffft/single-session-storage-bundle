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

interface SingleSessionStorageInterface
{
    /**
     * Reads an in a file stored session.
     *
     * @param string $name The session parameter name
     *
     * @return string The stored value
     *
     * @throws \Craffft\SingleSessionStorageBundle\Storage\Exception\SingleSessionNotFoundException If the session parameter name does not exist
     */
    public function get($name);

    /**
     * Stores a session in a file storage.
     *
     * @param string $name session parameter name
     * @param string $value   The value
     */
    public function set($name, $value);

    /**
     * Removes a session parameter.
     *
     * @param string $name The session parameter name
     *
     * @return string|null Returns the removed session parameter name if one existed, NULL
     *                     otherwise
     */
    public function remove($name);

    /**
     * Checks whether a value with the given name parameter exists.
     *
     * @param string $name The session parameter name
     *
     * @return bool Whether a session exists with the given parameter name
     */
    public function has($name);
}
