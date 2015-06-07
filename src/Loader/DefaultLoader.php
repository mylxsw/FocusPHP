<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\Loader;

use Focus\Config\ArrayConfig;
use Focus\Config\Config;
use Focus\Request\DefaultSession;
use Focus\Request\HttpRequest;
use Focus\Request\Request;
use Focus\Request\Session;
use Focus\Response\HttpResponse;
use Focus\Response\Response;
use Focus\Uri\DefaultUri;
use Focus\Uri\Uri;

class DefaultLoader implements Loader {
    private $_config = null;
    private $_request = null;
    private $_response = null;
    private $_uri = null;
    private $_session = null;

    public function getConfig() {
        if (is_null($this->_config)) {
            $this->setConfig(new ArrayConfig());
        }

        return $this->_config;
    }

    public function setConfig(Config $config) {
        $this->_config = $config;
    }

    /**
     * @return Request
     */
    public function getRequest() {
        if (is_null($this->_request)) {
            $this->setRequest(new HttpRequest());
        }
        return $this->_request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request ) {
        $this->_request = $request;
    }

    /**
     * @return Response
     */
    public function getResponse() {
        if (is_null($this->_response)) {
            $this->setResponse(new HttpResponse());
        }
        return $this->_response;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response ) {
        $this->_response = $response;
    }

    /**
     * @return Uri
     */
    public function getUri() {
        if (is_null($this->_uri)) {
            $this->setUri(new DefaultUri($this->getRequest()));
        }
        return $this->_uri;
    }

    /**
     * @param Uri $uri
     */
    public function setUri(Uri $uri ) {
        $this->_uri = $uri;
    }

    /**
     * @return Session
     */
    public function getSession() {
        if (is_null($this->_session)) {
            $this->setSession(new DefaultSession());
        }
        return $this->_session;
    }

    /**
     * @param Session $session
     */
    public function setSession(Session $session ) {
        $this->_session = $session;
    }
} 