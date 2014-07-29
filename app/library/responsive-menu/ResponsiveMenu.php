<?php

class ResponsiveMenu {
    
    protected $options;
    protected $version;
    
    public function __construct() {
        
        $this->options = !is_array( get_option( 'RMOptions' ) ) ? unserialize( get_option( 'RMOptions' ) ) :  get_option( 'RMOptions' );
        $this->version = get_option( 'RMVer' );
        
        Registry::set( 'options', $this->options );
        Registry::set( 'version', $this->version );
        
    }
    
    public function run() {
        
        register_activation_hook( __FILE__, array( 'InstallController', 'install' ) );
        add_action( 'admin_menu', array( 'AdminController', 'addMenus' ) );
        add_action( 'admin_enqueue_scripts', array( 'AdminController', 'Colorpicker' ) );
        add_action( 'wp_enqueue_scripts', array( 'GlobalController', 'jQuery' ) );
        add_action( 'plugins_loaded', array( 'GlobalController', 'Internationalise' ) );
   
//        add_action( 'wp_footer', array( 'ResponsiveMenu', 'displayMenuHtml' ) );
//        add_action( 'wp_enqueue_scripts', array( 'ResponsiveMenu', 'ExternalScripts' ) );
//        add_action( 'wp_head', array( 'ResponsiveMenu', 'InlineCSS' ) ); 
//        add_action( $inFooter, array( 'ResponsiveMenu', 'InlineJavaScript' ) ); 
 
        
    }
    
}