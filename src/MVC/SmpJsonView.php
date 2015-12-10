<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\MVC;


use Focus\Response\Response;

class SmpJsonView implements View {

    private $_data = [];

    public function output(Response $response) {
        $response->header('Content-Type:text/json; charset=utf-8');
        $response->write($this->render());
    }

    /**
     * View template render
     *
     * @param string|null $templateName Template name
     * @param array $data data for template parser
     *
     * @return string
     */
    public function render(\string $templateName = null, array $data = []): \string
    {
        $this->setTemplate($templateName, $data);
        return json_encode($this->_data);
    }

    /**
     * passing data to template parser
     *
     * @param string $key data key
     * @param mixed $value data body
     *
     * @return View
     */
    public function assign(\string $key, $value ): View
    {
        if (empty($key)) {
            throw new \RuntimeException('ASSIGN_KEY_EMPTY');
        }
        $this->_data[$key] = $value;

        return $this;
    }

    /**
     * set the template file
     *
     * @param string $templateName template name
     * @param array $data data for template parser
     *
     * @return View
     */
    public function setTemplate(\string $templateName = null, array $data = []): View
    {
        if (!empty($data)) {
            if (is_array($data)) {
                $this->_data = array_merge($this->_data, $data);
            }
        }

        return $this;
    }

    /**
     * view construct method
     *
     * @param string|null $templateName template name
     * @param array $data data for template parser
     */
    public function __construct(\string $templateName = null, array $data = [])
    {
        $this->setTemplate($templateName, $data);
    }

    /**
     * Remove a key from data array
     *
     * @param string $key the key to remove
     *
     * @return View
     */
    public function remove(\string $key): View
    {
        if (isset($this->_data[$key])) {
            unset($this->_data[$key]);
        }

        return $this;
    }

    /**
     * Get all data as array
     *
     * @return []
     */
    public function data(): array
    {
        return $this->_data;
    }
}