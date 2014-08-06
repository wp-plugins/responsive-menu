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
        add_action( 'wp_enqueue_scripts', array( 'RM_GlobalController', 'jQueryMobile' ) );

         
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
     * Makes sure jQuery Mobile is added to all pages as it is needed for some of the functions
     * to work
     *
     * @return null
     * @added 2.0
     */
    
    static function jQueryMobile() {
        
        wp_register_script( 'touch', RM_Registry::get( 'config', 'plugin_base_uri' ) . 'public/js/touch.js', 'jquery', '', false );
	wp_enqueue_script( 'touch' ); 

    }
    
    
    /**
     * Loads our Translations for use throughout the program
     *
     * Current Translations:
     * 
     * hr_HR - Croatian - With thanks to Neverone Design - https://www.facebook.com/pages/Neverone-design/490262371018076
     * es_ES - Spanish - With thanks to Andrew @ WebHostingHub - http://www.webhostinghub.com
     * 
     * @return null 
     * @added 1.6
     */
    
    
    static function Internationalise() {

        
        __( 'Highly Customisable Responsive Menu Plugin Created By Peter Featherstone', 'responsive-menu' );
        
        load_plugin_textdomain( 'responsive-menu', false, 'responsive-menu/translations/' );

        
    }
    
    
}