<?php


class GlobalController extends BaseController {
    
    
    /**
     * Makes sure jQuery is added to all pages as it is needed for the
     * system to work
     *
     * @return null
     * @added 1.0
     */
    
    function jQuery() {
        
        
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
    
    
    function Internationalise() {

        load_plugin_textdomain( 'responsive-menu', false, Registry::get( 'config', 'plugin_base_dir' ) . '/translations/' );

    }
    
    
}