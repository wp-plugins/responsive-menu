<?php


class RM_GlobalController extends RM_BaseController {
    
        
    /**
     * Prepare our Global Options
     *
     * @return null
     * @added 2.0
     */
    
    static function prepare() {
        
        
        add_action( 'plugins_loaded', array( 'RM_GlobalController', 'Internationalise' ) );
        add_action( 'wp_enqueue_scripts', array( 'RM_GlobalController', 'jQuery' ) );
        
        
    }
    

    /**
     * Makes sure jQuery is added to all pages as it is needed for the
     * system to work
     *
     * @return null
     * @added 1.0
     */
    
    static function jQuery() {
        
        
        wp_enqueue_script( 'jquery' );
        
        
    }
    
    /**
     * Loads our Translations for use throughout the program
     *
     * Current Translations:
     * 
     * hr_HR - Croatian - With thanks to 
     * es_ES - Spanish - With thanks to
     * 
     * @return null
     * @added 1.6
     */
    
    
    static function Internationalise() {

        load_plugin_textdomain( 'responsive-menu', false, RM_Registry::get( 'config', 'plugin_base_dir' ) . '/translations/' );

    }
    
    
}