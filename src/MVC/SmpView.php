<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\MVC;


use Focus\Log\LoggerAwareTrait;
use Focus\Response\Response;

class SmpView implements View {

    use LoggerAwareTrait;

    private $_templateName = 'index.php';
    private $_suffix = '.php';
    /**
     * @var []
     */
    private $_data = [];
    private $_layout;

    /**
     * View template render
     *
     * @param string|null $templateName Template name
     * @param array       $data         data for template parser
     *
     * @return string
     */
    public function render( $templateName = null, $data = [ ] ) {
        $this->setTemplate($templateName, $data);

        if (empty($this->_templateName)) {
            $this->getLogger()->warning('template name is null');
            throw new \RuntimeException('TEMPLATE_IS_NULL');
        }
        $buffer = $this->_parseTemplate($this->_templateName, $this->_data);
        if (!empty($this->_layout)) {
            $this->getLogger()->debug('loading layout: ' . $this->_layout);
            $buffer = $this->_parseTemplate(
                $this->_layout,
                array_merge($this->_data, ['__body__' => $buffer])
            );
        }

        return $buffer;
    }

    private function _parseTemplate($templateName, $data) {
        if (!file_exists($templateName)) {
            if (isset($data['__body__'])) {
                return $data['__body__'];
            }
            return '';
        }


        @extract($data);
        ob_start();
        include $templateName;
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }

    /**
     * passing data to template parser
     *
     * @param string $key data key
     * @param mixed $value data body
     *
     * @return View
     */
    public function assign( $key, $value ) {
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
    public function setTemplate( $templateName, $data = [ ] ) {
        if (!empty($templateName)) {
            $this->_templateName = $templateName . $this->_suffix;
        }

        if (!empty($data)) {
            if (is_array($data)) {
                $this->_data = array_merge($this->_data, $data);
            } else {
                $this->_data['__data__'] = $data;
            }
        }

        return $this;
    }

    /**
     * view construct method
     *
     * @param string|null $templateName template name
     * @param array       $data         data for template parser
     * @param string|null $layout       layout name
     */
    public function __construct( $templateName = null, $data = [ ], $layout = 'Views/_layouts/default') {
        $this->setTemplate($templateName, $data);
        $this->setLayout($layout);
    }

    /**
     * set the default layout name
     *
     * @param string|null $layoutName layout name
     */
    public function setLayout($layoutName) {
        $this->_layout = empty($layoutName) ? null : $layoutName . $this->_suffix;
    }

    /**
     * Write output to response object
     *
     * @param Response $response
     *
     * @return mixed
     */
    public function output( Response $response ) {
        $response->header('Content-Type:text/html; charset=utf-8');
        $response->write($this->render());
    }

    /**
     * Remove a key from data array
     *
     * @param string $key the key to remove
     *
     * @return View
     */
    public function remove( $key ) {
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
    public function data() {
        return $this->_data;
    }
}