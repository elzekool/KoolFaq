<?php
/**
 * Shortcodes
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 */

/**
 * htmlspecialchars shortcut
 * 
 * @param string $string Input
 * 
 * @return string Output
 */
function _h($string) {
    return htmlspecialchars($string);
}
