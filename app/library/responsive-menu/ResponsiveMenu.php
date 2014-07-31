<?php


class ResponsiveMenu {
    
    
    /**
     * Main Construct for the Whole Application
     * Sets Registry and Default Values (if none present)
     *
     * @return null
     * @added 2.0
     */
    
    public function __construct() {
        
        
        if( !get_option( 'RMVer' ) )
                add_option( 'RMVer', Registry::get( 'config', 'current_version' ) );
                
        
        if( !get_option( 'RMOptions' ) )
            add_option( 'RMOptions', Registry::get( 'defaults' ) );
        
        
        Registry::set( 'options', get_option( 'RMOptions' ) );
        Registry::set( 'version', get_option( 'RMVer' ) );

        
    }
    
        
    /**
     * The main application run function, this sets up all the magic and grunt
     * work of the application, firing off all the different controllers.
     *
     * @return null
     * @added 2.0
     */
    
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