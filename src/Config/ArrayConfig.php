<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the
 *            LICENSE file)
 */

namespace Focus\Config;


class ArrayConfig implements Config
{
    private $_filenames = [];
    private $_configs   = [];

    public function __construct(...$filenames)
    {
        $this->_filenames = $filenames;
        $this->reload();
    }

    /**
     * Get config info
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return null|string
     */
    public function get($key, $default = null)
    {

        if ( ! isset($this->_configs[$key])) {
            $cfg = get_cfg_var($key);
            if ($cfg !== false) {
                return $cfg;
            }

            return $default;
        }

        return $this->_configs[$key];
    }

    public function set($key, $value)
    {
        $this->_configs[$key] = $value;
    }

    public function reload()
    {
        if (empty($this->_filenames)) {
            return;
        }

        $this->_configs = [];
        foreach ($this->_filenames as $filename) {
            if ( ! file_exists($filename)) {
                throw new \ErrorException("CONFIG_FILE_NOT_FOUND");
            }

            $configs = include $filename;
            if ( ! is_array($configs)) {
                throw new \DomainException('INVALID_CONFIG_FORMAT');
            }

            $this->_configs = array_merge($this->_configs, $configs);
        }
    }
}