<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Libraries;


class Tools {


    /**
     * Create page info
     *
     * @param int $total   总记录数目
     * @param int $count   每页显示数量
     * @param int $current 当前页码
     *
     * @return array [总计路数, 当前偏移, 每页显示数目, 页码总数, 当前页码]
     */
    public static function createPageInfo( $total, $count, $current ) {
        $count     = intval( $count );
        $page_nums = intval( ( $total / $count ) ) + ( ( $total % $count ) == 0 ? 0 : 1 );
        if ( $current < 1 || $current > $page_nums ) {
            $current = 1;
        }
        $offset = ( $current - 1 ) * $count;

        return [$total, $offset, $count, $page_nums, $current];
    }

    /**
     * 生成摘要
     *
     * [本代码来自网络]
     *
     * @param string $body 正文
     * @param int    $size 摘要长度
     * @param int    $format 输入格式 id
     *
     * @return string
     */
    public static function blogSummary( $body, $size, $format = null ) {
        $_size = mb_strlen( $body, 'utf-8' );
        if ( $_size <= $size ) {
            return $body;
        }
        // 输入格式中有 PHP 过滤器
        $strlen_var = strlen( $body );
        // 不包含 html 标签
        if ( strpos( $body, '<' ) === false ) {
            return mb_substr( $body, 0, $size );
        }
        // 包含截断标志，优先
        if ( $e = strpos( $body, '<!-- break -->' ) ) {
            return mb_substr( $body, 0, $e );
        }
        // html 代码标记
        $html_tag = 0;
        // 摘要字符串
        $summary_string = '';
        /**
         * 数组用作记录摘要范围内出现的 html 标签
         * 开始和结束分别保存在 left 和 right 键名下
         * 如字符串为：<h3><p><b>a</b></h3>，假设 p 未闭合
         * 数组则为：array('left' => array('h3', 'p', 'b'), 'right' => 'b', 'h3');
         * 仅补全 html 标签，<? <% 等其它语言标记，会产生不可预知结果
         */
        $html_array = array( 'left' => array(), 'right' => array() );
        for ( $i = 0; $i < $strlen_var; ++ $i ) {
            if ( ! $size ) {
                break;
            }
            $current_var = substr( $body, $i, 1 );
            if ( $current_var == '<' ) {
                // html 代码开始
                $html_tag       = 1;
                $html_array_str = '';
            } else if ( $html_tag == 1 ) {
                // 一段 html 代码结束
                if ( $current_var == '>' ) {
                    /**
                     * 去除首尾空格，如 <br /  > < img src="" / > 等可能出现首尾空格
                     */
                    $html_array_str = trim( $html_array_str );
                    /**
                     * 判断最后一个字符是否为 /，若是，则标签已闭合，不记录
                     */
                    if ( substr( $html_array_str, - 1 ) != '/' ) {
                        // 判断第一个字符是否 /，若是，则放在 right 单元
                        $f = substr( $html_array_str, 0, 1 );
                        if ( $f == '/' ) {
                            // 去掉 /
                            $html_array['right'][] = str_replace( '/', '', $html_array_str );
                        } else if ( $f != '?' ) {
                            // 判断是否为 ?，若是，则为 PHP 代码，跳过
                            /**
                             * 判断是否有半角空格，若有，以空格分割，第一个单元为 html 标签
                             * 如 <h2 class="a"> <p class="a">
                             */
                            if ( strpos( $html_array_str, ' ' ) !== false ) {
                                // 分割成2个单元，可能有多个空格，如：<h2 class="" id="">
                                $html_array['left'][] = strtolower( current( explode( ' ', $html_array_str, 2 ) ) );
                            } else {
                                /**
                                 * * 若没有空格，整个字符串为 html 标签，如：<b> <p> 等
                                 * 统一转换为小写
                                 */
                                $html_array['left'][] = strtolower( $html_array_str );
                            }
                        }
                    }
                    // 字符串重置
                    $html_array_str = '';
                    $html_tag       = 0;
                } else {
                    /**
                     * 将< >之间的字符组成一个字符串
                     * 用于提取 html 标签
                     */
                    $html_array_str .= $current_var;
                }
            } else {
                // 非 html 代码才记数
                -- $size;
            }
            $ord_var_c = ord( $body{$i} );
            switch ( true ) {
                case ( ( $ord_var_c & 0xE0 ) == 0xC0 ):
                    // 2 字节
                    $summary_string .= substr( $body, $i, 2 );
                    $i += 1;
                    break;
                case ( ( $ord_var_c & 0xF0 ) == 0xE0 ):
                    // 3 字节
                    $summary_string .= substr( $body, $i, 3 );
                    $i += 2;
                    break;
                case ( ( $ord_var_c & 0xF8 ) == 0xF0 ):
                    // 4 字节
                    $summary_string .= substr( $body, $i, 4 );
                    $i += 3;
                    break;
                case ( ( $ord_var_c & 0xFC ) == 0xF8 ):
                    // 5 字节
                    $summary_string .= substr( $body, $i, 5 );
                    $i += 4;
                    break;
                case ( ( $ord_var_c & 0xFE ) == 0xFC ):
                    // 6 字节
                    $summary_string .= substr( $body, $i, 6 );
                    $i += 5;
                    break;
                default:
                    // 1 字节
                    $summary_string .= $current_var;
            }
        }
        if ( $html_array['left'] ) {
            /**
             * 比对左右 html 标签，不足则补全
             */
            /**
             * 交换 left 顺序，补充的顺序应与 html 出现的顺序相反
             * 如待补全的字符串为：<h2>abc<b>abc<p>abc
             * 补充顺序应为：</p></b></h2>
             */
            $html_array['left'] = array_reverse( $html_array['left'] );
            foreach ( $html_array['left'] as $index => $tag ) {
                // 判断该标签是否出现在 right 中
                $key = array_search( $tag, $html_array['right'] );
                if ( $key !== false ) {
                    // 出现，从 right 中删除该单元
                    unset( $html_array['right'][ $key ] );
                } else {
                    // 没有出现，需要补全
                    $summary_string .= '</' . $tag . '>';
                }
            }
        }

        return $summary_string;
    }
} 