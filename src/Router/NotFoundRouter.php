<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the
 *            LICENSE file)
 */

namespace Focus\Router;


use Focus\Log\LoggerAwareTrait;
use Focus\Request\Request;
use Focus\Response\Response;

class NotFoundRouter implements Route
{

    use LoggerAwareTrait;

    /**
     * @param string $pathinfo
     * @param int    $index
     *
     * @return bool
     * @throws \ErrorException
     */
    public function isMatched(\string $pathinfo, \int $index): \bool
    {
        throw new \ErrorException('不支持该方法');
    }

    /**
     * 处理请求
     *
     * @param Request  $request  Request Object
     * @param Response $response Response Object
     * @param mixed    $params
     *
     * @return void
     */
    public function execute(Request $request, Response $response, ...$params)
    {
        if (defined('FOCUS_DEBUG') && FOCUS_DEBUG) {
            $this->getLogger()->debug('404 - Not Found');
        }

        $response->header('HTTP/1.1 404 Not Found');
        if (!empty($params)) {
            $response->write(...$params);
        } else {
            $response->write("Not Found.");
        }
    }

    /**
     * @throws \ErrorException
     */
    public function isContinue(): \bool
    {
        throw new \ErrorException('不支持该方法');
    }
}