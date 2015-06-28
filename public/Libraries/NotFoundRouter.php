<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Libraries;


use Focus\Request\Request;
use Focus\Response\Response;

class NotFoundRouter extends \Focus\Router\NotFoundRouter {
    public function execute( Request $request, Response $response, ...$params ) {
        $this->getLogger()->debug('404 - Not Found');
        $response->header('HTTP/1.1 404 Not Found');

        ob_start();
        include BASE_PATH . '/Views/404.php';
        $content = ob_get_contents();
        ob_end_clean();


        $response->write($content);
    }

} 