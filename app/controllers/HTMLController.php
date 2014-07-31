<?php


class HTMLController extends BaseController {
    
    
    /**
     * Prepare the HTML for display on the front end
     *
     * @return null
     * @added 1.0
     */
    
    function prepare() {
        
        
        add_action( 'wp_footer', array( 'HTMLController', 'display' ) );
        
        
    }
    
    
    /**
     * Creates the view for the menu and echos it out
     *
     * @return string
     * @added 1.0
     */
    
    function display() {
        
         
        View::make( 'menu', Registry::get( 'options' ) );
     
        
    }
    
    
}