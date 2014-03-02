<?php

/*
Plugin Name: Responsive Menu
Plugin URI: http://www.peterfeatherstone.com/responsive-menu/
Description: Highly Customisable Responsive Menu Plugin Created By Peter Featherstone @ Network Intellect.
Version: 1.4
Author: Peter Featherstone
Author URI: http://www.peterfeatherstone.com/responsive-menu/
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

/* 1.3 Make Sure We Have jQuery ============= */
function jQuery(){ 
    
  wp_enqueue_script( 'jquery' );
  
}

add_action('wp_enqueue_scripts', 'jQuery');
//wp_enqueue_script( 'jquery' );

/* ====================
   2. Installation
   =================== */

register_activation_hook( __FILE__, array( '\PeterFeatherstone\ResponsiveMenu\ResponsiveMenu', 'install' ) );

/* ====================
   3. Admin Menu Registrations
   =================== */

/* 3.1 Main Menu ============= */
add_action( 'admin_menu', array( '\PeterFeatherstone\ResponsiveMenu\ResponsiveMenu', 'menus' ) );

/* ====================
   4. Display
   =================== */

/* 4.1 Display Responsive Menu on Site ============= */
if( !is_admin() ) :

    add_action( 'wp_head', array( '\PeterFeatherstone\ResponsiveMenu\ResponsiveMenu', 'displayMenu' ) );

endif;

/* 4.2 Add Colour Picker to Admin Pages ============= */
if( is_admin() && isset( $_GET['page'] ) && $_GET['page'] == 'responsive-menu' ) :

    function Colorpicker(){ 
    
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker');
        wp_enqueue_script( 'wp-color-picker');

    }

    add_action('admin_enqueue_scripts', 'Colorpicker');

endif;