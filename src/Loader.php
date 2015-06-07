<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */
namespace Focus;

use Focus\Config\Config;
use Focus\Loader\DefaultLoader;
use Focus\Request\Request;
use Focus\Request\Session;
use Focus\Response\Response;
use Focus\Uri\Uri;

class Loader implements Loader\Loader {

    private static $_instance;
    /**
     * @var Loader/Loader
     */
    private $_loader;

    public static function instance() {
        if (empty(self::$_instance)) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public function setLoader(Loader\Loader $loader) {
        $this->_loader = $loader;
    }

    public function getLoader() {
        if (is_null($this->_loader)) {
            $this->setLoader(new DefaultLoader());
        }
        return $this->_loader;
    }


    public function getConfig() {
        return $this->getLoader()->getConfig();
    }

    public function setConfig( Config $config ) {
        $this->getLoader()->setConfig($config);
    }

    /**
     * @return Request
     */
    public function getRequest() {
        return $this->getLoader()->getRequest();
    }

    /**
     * @param Request $request
     */
    public function setRequest( Request $request ) {
        $this->getLoader()->setRequest($request);
    }

    /**
     * @return Response
     */
    public function getResponse() {
        return $this->getLoader()->getResponse();
    }

    /**
     * @param Response $response
     */
    public function setResponse( Response $response ) {
        $this->getLoader()->setResponse($response);
    }

    /**
     * @return Uri
     */
    public function getUri() {
        return $this->getLoader()->getUri();
    }

    /**
     * @param Uri $uri
     */
    public function setUri( Uri $uri ) {
        $this->getLoader()->setUri($uri);
    }

    /**
     * @return Session
     */
    public function getSession() {
        return $this->getLoader()->getSession();
    }

    /**
     * @param Session $session
     */
    public function setSession( Session $session ) {
        $this->getLoader()->setSession($session);
    }
}