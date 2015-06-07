<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\Loader;

use Focus\Config\Config;
use Focus\Request\Request;
use Focus\Request\Session;
use Focus\Response\Response;
use Focus\Uri\Uri;

interface Loader {

    public function getConfig();

    public function setConfig(Config $config);

    /**
     * @return Request
     */
    public function getRequest();

    /**
     * @param Request $request
     */
    public function setRequest(Request $request );

    /**
     * @return Response
     */
    public function getResponse();

    /**
     * @param Response $response
     */
    public function setResponse(Response $response );

    /**
     * @return Uri
     */
    public function getUri();

    /**
     * @param Uri $uri
     */
    public function setUri(Uri $uri );

    /**
     * @return Session
     */
    public function getSession();

    /**
     * @param Session $session
     */
    public function setSession(Session $session );

} 