<?php

class ResponsiveMenu {
    
    protected $options;
    protected $version;
    
    public function __construct() {
        
        $this->options = !is_array( get_option( 'RMOptions' ) ) ? unserialize( get_option( 'RMOptions' ) ) :  get_option( 'RMOptions' );
        $this->version = get_option( 'RMVer' );
        
    }
    
    public function run() {
        
        add_action( 'wp_enqueue_scripts', array( 'ResponsiveMenu', 'jQuery' ) );
        register_activation_hook( __FILE__, array( 'ResponsiveMenu', 'install' ) );
        add_action( 'admin_menu', array( 'ResponsiveMenu', 'menus' ) );
        add_action( 'wp_footer', array( 'ResponsiveMenu', 'displayMenuHtml' ) );
        add_action( 'wp_enqueue_scripts', array( 'ResponsiveMenu', 'ExternalScripts' ) );
        add_action( 'wp_head', array( 'ResponsiveMenu', 'InlineCSS' ) ); 
        add_action( $inFooter, array( 'ResponsiveMenu', 'InlineJavaScript' ) ); 
        add_action( 'admin_enqueue_scripts', array( 'ResponsiveMenu', 'Colorpicker' ) );
        add_action( 'plugins_loaded', array( 'ResponsiveMenu', 'Internationalise' ) );
        
    }
    
}