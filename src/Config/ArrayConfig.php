<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\Config;


class ArrayConfig implements Config {
    private $_filename;
    private $_configs = [];

    public function __construct($filename = null) {
        $this->_filename = $filename;
        $this->reload();
    }

    public function get( $key, $default = null ) {
        return isset($this->_configs[$key]) ? $this->_configs[$key] : $default;
    }

    public function set( $key, $value ) {
        $this->_configs[$key] = $value;
    }

    public function reload() {
        if (empty($this->_filename)) {
            return;
        }

        if (!file_exists($this->_filename)) {
            throw new \ErrorException("CONFIG_FILE_NOT_FOUND");
        }

        $this->_configs = include $this->_filename;
        if (!is_array($this->_configs)) {
            throw new \DomainException('INVALID_CONFIG_FORMAT');
        }
    }
}