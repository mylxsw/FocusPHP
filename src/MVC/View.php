<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\MVC;


interface View {

    /**
     * View template render
     *
     * @param string|null $templateName Template name
     * @param array       $data         data for template parser
     *
     * @return string
     */
    public function render($templateName = null, $data = []);

    /**
     * passing data to template parser
     *
     * @param string $key   data key
     * @param mixed  $value data body
     *
     * @return void
     */
    public function assign($key, $value);

    /**
     * set the template file
     *
     * @param string $templateName template name
     * @param array  $data         data for template parser
     *
     * @return mixed
     */
    public function setTemplate($templateName, $data = []);

    /**
     * view construct method
     *
     * @param string|null $templateName template name
     * @param array       $data         data for template parser
     */
    public function __construct($templateName = null, $data = []);

}