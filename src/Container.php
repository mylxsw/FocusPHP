<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the
 *            LICENSE file)
 */

namespace Focus;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Interop\Container\Exception\NotFoundException;


class Container implements ContainerInterface
{

    protected static $instance;
    private          $_container;

    private function __construct()
    {
    }

    /**
     * Get the container instance singleton
     *
     * @return Container
     */
    public static function instance(): Container
    {
        if (empty(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Set container instance
     *
     * @param ContainerInterface $container
     *
     * @return Container
     */
    public function setContainer(ContainerInterface $container): Container
    {
        $this->_container = $container;

        return $this;
    }

    /**
     * Get container instance
     *
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        if (empty($this->_container)) {
            $this->_container = new BasicContainer();
        }

        return $this->_container;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundException  No entry was found for this identifier.
     * @throws ContainerException Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        return $this->getContainer()->get($id);
    }

    /**
     * Returns true if the container can return an entry for the given
     * identifier. Returns false otherwise.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return boolean
     */
    public function has($id)
    {
        return $this->getContainer()->has($id);
    }
}