<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the
 *            LICENSE file)
 */

namespace Focus;


class ContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testHello()
    {
        $this->assertTrue(true);

        echo self::hello("mylxsw");
    }

    public static function hello(\string $name): \string
    {
        return "Hello, {$name}";
    }
}
