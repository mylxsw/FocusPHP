<?php
/**
 * FocusPHP.
 *
 * @link      http://aicode.cc/
 *
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */
namespace Focus\MVC;

use Focus\Response\Response;

interface View
{
    /**
     * View template render.
     *
     * @param string|null $templateName Template name
     * @param array       $data         data for template parser
     *
     * @return string
     */
    public function render($templateName = null, $data = []);

    /**
     * passing data to template parser.
     *
     * @param string $key   data key
     * @param mixed  $value data body
     *
     * @return View
     */
    public function assign($key, $value);

    /**
     * Remove a key from data array.
     *
     * @param string $key the key to remove
     *
     * @return View
     */
    public function remove($key);

    /**
     * set the template file.
     *
     * @param string $templateName template name
     * @param array  $data         data for template parser
     *
     * @return View
     */
    public function setTemplate($templateName, $data = []);

    /**
     * view construct method.
     *
     * @param string|null $templateName template name
     * @param array       $data         data for template parser
     */
    public function __construct($templateName = null, $data = []);

    /**
     * Write output to response object.
     *
     * @param Response $response
     *
     * @return mixed
     */
    public function output(Response $response);

    /**
     * Get all data as array.
     *
     * @return []
     */
    public function data();
}
