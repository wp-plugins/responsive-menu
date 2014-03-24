<?php

/*
Plugin Name: Responsive Menu
Plugin URI: http://www.peterfeatherstone.com/wordpress/responsive-menu/
Description: Highly Customisable Responsive Menu Plugin Created By Peter Featherstone @ Network Intellect.
Version: 1.8
Author: Peter Featherstone
Text Domain: responsive-menu
Author URI: http://www.peterfeatherstone.com/wordpress/responsive-menu/
License: GPL2
Tags: responsive, menu, responsive menu

    Copyright 2014  Peter Featherstone <hello@peterfeatherstone.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

/* ====================
   1. Initial Setup
   =================== */

/* 1.1 Include Main Class File ============= */
require_once( 'classes/class.responsiveMenu.php' );

/* 1.2 Define Our Plugin Constants ============= */
define( 'RM_IMAGES', plugin_dir_url( __FILE__ ) . 'imgs/' );
define( 'RM_JS', plugin_dir_url( __FILE__ ) . 'js/' );
define( 'RM_V', 1.8 );

/* 1.3 Make Sure We Have jQuery ============= */
add_action('wp_enqueue_scripts', array( 'ResponsiveMenu', 'jQuery' ) );

/* ====================
   2. Installation
   =================== */

register_activation_hook( __FILE__, array( 'ResponsiveMenu', 'install' ) );

/* ====================
   3. Admin Menu Registrations
   =================== */

/* 3.1 Main Menu ============= */
add_action( 'admin_menu', array( 'ResponsiveMenu', 'menus' ) );

/* ====================
   4. Display
   =================== */

/* 4.1 Display Responsive Menu on Site ============= */
if( !is_admin() ) :

    add_action( 'wp_head', array( 'ResponsiveMenu', 'displayMenu' ) );
    add_action( 'wp_footer', array( 'ResponsiveMenu', 'displayMenuHtml' ) );

endif;

/* 4.2 Add Colour Picker to Admin Pages ============= */
if( is_admin() && isset( $_GET['page'] ) && $_GET['page'] == 'responsive-menu' ) :

    add_action('admin_enqueue_scripts', array( 'ResponsiveMenu', 'Colorpicker' ) );

endif;

function internationaliseResponsiveMenu() {
    
    load_plugin_textdomain( 'responsive-menu', false, basename( dirname( __FILE__) )  . '/translations/' );
 
}

add_action( 'plugins_loaded', 'internationaliseResponsiveMenu' );