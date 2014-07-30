<?php

class ResponsiveMenu {
    
    
    public function __construct() {
        
        if( !get_option( 'RMVer' ) )
                add_option( 'RMVer', Registry::get( 'config', 'current_version' ) );
                
        if( !get_option( 'RMOptions' ) )
            add_option( 'RMOptions', Registry::get( 'defaults' ) );
        
        
        Registry::set( 'options', get_option( 'RMOptions' ) );
        Registry::set( 'version', get_option( 'RMVer' ) );

        
    }
    
    
    public function run() {
        
        add_action( 'plugins_loaded', array( 'GlobalController', 'Internationalise' ) );
        
        register_activation_hook( __FILE__, array( 'InstallController', 'install' ) );
        
        UpgradeController::upgrade();
        
        add_action( 'wp_enqueue_scripts', array( 'GlobalController', 'jQuery' ) );
        
        add_action( 'admin_menu', array( 'AdminController', 'addMenus' ) );
        add_action( 'admin_enqueue_scripts', array( 'AdminController', 'colorpicker' ) );
        
        HTMLController::prepare();
        CSSController::prepare();
        JSController::prepare();
     
     
    }
    
    
}