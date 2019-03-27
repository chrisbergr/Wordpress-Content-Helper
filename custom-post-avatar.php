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

function convert_to_ascii( $str ) {
    $pieces = str_split( trim( $str ) );
    $new_str = '';
    foreach( $pieces as $val ) {
        $new_str .= '&#' . ord( $val ) . ';';
    }
    return $new_str;
}

function process_email( $atts, $content = false ) {
    extract( shortcode_atts( array(
        "mailto" => false,
    ), $atts ) );
    if ( ! $mailto && ! $content ) {
        if ( ! empty( $atts[0] ) ) {
            $mailto = str_replace( '=', '', str_replace( '"', '', $atts[0] ) );
            $content = $mailto;
        } else {
            return 'EMAIL MISSING';
        }
    }
    if ( ! $mailto ) {
        $mailto = $content;
    }
    if ( ! $content ) {
        $content = $mailto;
    }
    $out = sprintf(
        '<a href="%s">%s</a>',
        convert_to_ascii( 'mailto:' . $mailto ),
        convert_to_ascii( $content )
    );
    return $out;
}
add_shortcode( 'email', 'process_email' );
