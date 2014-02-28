<?php

/*
Plugin Name: Responsive Menu
Plugin URI: http://www.peterfeatherstone.com/responsive-menu/
Description: Highly Customisable Responsive Menu Plugin Created By Peter Featherstone @ Network Intellect.
Version: 1.2
Author: Peter Featherstone
Author URI: http://www.peterfeatherstone.com/responsive-menu/
License: GPL2
Tags: responsive, menu, responsive menu
	
*/

require_once( 'classes/class.responsiveMenu.php' );

define( 'RM_IMAGES', plugin_dir_url( __FILE__ ) . 'imgs/' );
define( 'RM_JS', plugin_dir_url( __FILE__ ) . 'js/' );

wp_enqueue_script( 'jquery' );

register_activation_hook( __FILE__, array( '\PeterFeatherstone\ResponsiveMenu\ResponsiveMenu', 'install' ) );

add_action( 'admin_menu', array( '\PeterFeatherstone\ResponsiveMenu\ResponsiveMenu', 'menus' ) );

if( !is_admin() ) :

    add_action( 'wp_head', array( '\PeterFeatherstone\ResponsiveMenu\ResponsiveMenu', 'displayMenu' ) );

endif;

if( is_admin() && $_GET['page'] == 'responsive-menu' ) :
 
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );

endif;
