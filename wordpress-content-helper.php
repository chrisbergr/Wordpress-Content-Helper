<?php
/*
Plugin Name: WordPress Content Helper
Plugin URI:  https://github.com/chrisbergr/Wordpress-Content-Helper
Description: WordPress Content Helper adds some helper functionality to the contents of a WordPress page.
Version:     0.9.1
Text Domain: wordpress-content-helper
Author:      Christian Hockenberger
Author URI:  https://christian.hockenberger.us
License:     GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2019 Christian Hockenberger (christian@hockenberger.us)
WordPress Content Helper is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

WordPress Content Helper is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with WordPress Content Helper. If not, see http://www.gnu.org/licenses/gpl-2.0.html.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Returns string with ASCII convertet characters
 *
 * @since 0.9.1
 * @access public
 *
 * @param string $str
 * @return string
 */
function convert_to_ascii( $str ) {

	$pieces = str_split( trim( $str ) );
	$new_str = '';

	foreach( $pieces as $val ) {
		$new_str .= '&#' . ord( $val ) . ';';
	}

	return $new_str;

}

/**
 * Convert email addresses into ASCII strings to optimistically protect them from spambots
 *
 * Output:
 * <a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;&#109;&#97;&#105;&#108;&#64;&#101;&#120;&#97;&#109;&#112;&#108;&#101;&#46;&#99;&#111;&#109;">&#76;&#105;&#110;&#107;&#116;&#105;&#116;&#108;&#101;</a>
 *
 * @since 0.9.1
 * @access public
 *
 * @param string $content Content from the WordPress filter
 * @return string
 */
function process_email( $content ) {

	$pattern = '/(mailto\:)?[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i';
	preg_match_all( $pattern, $content, $matches );

	foreach ( $matches[0] as $key => $replacement ) {
		$content = preg_replace( $pattern, convert_to_ascii( $replacement ), $content, 1 );
	}

	return $content;

}
add_filter( 'the_content', 'process_email' );
add_filter( 'the_excerpt', 'process_email' );
add_filter( 'widget_text', 'process_email' );
