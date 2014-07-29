<?php

class ResponsiveMenu {
    
    
    public function __construct() {
        
        
        Registry::set( 'options', get_option( 'RMOptions' ) );
        Registry::set( 'version', get_option( 'RMVer' ) );
        
        
    }
    
    
    public function run() {
        
        
        register_activation_hook( __FILE__, array( 'InstallController', 'install' ) );
        add_action( 'admin_menu', array( 'AdminController', 'addMenus' ) );
        add_action( 'admin_enqueue_scripts', array( 'AdminController', 'colorpicker' ) );
        add_action( 'wp_enqueue_scripts', array( 'GlobalController', 'jQuery' ) );
        add_action( 'plugins_loaded', array( 'GlobalController', 'Internationalise' ) );
        add_action( 'wp_footer', array( 'HTMLController', 'display' ) );
        
        CSSController::prepare();
        JSController::prepare();
        
//        add_action( 'wp_enqueue_scripts', array( 'ResponsiveMenu', 'ExternalScripts' ) );
//        add_action( 'wp_head', array( 'ResponsiveMenu', 'InlineCSS' ) ); 
//        add_action( $inFooter, array( 'ResponsiveMenu', 'InlineJavaScript' ) ); 
 
        
    }
    
    
}