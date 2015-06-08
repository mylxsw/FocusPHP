<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\MVC;


interface ORM {

    /**
     * Get table name
     *
     * @return string
     */
    public function getTableName();

    /**
     * Get the name of all columns in the table
     *
     * @return string[]
     */
    public function getColumnNames();

    /**
     * Get the primary keys
     *
     * @return string[]
     */
    public function getPrimaryKeys();

}