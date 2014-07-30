<?php


class HTMLController extends BaseController {
    
    
    function prepare() {
        
        add_action( 'wp_footer', array( 'HTMLController', 'display' ) );
        
    }
    
    function display() {
        
         
        View::make( 'menu', Registry::get( 'options' ) );
     
        
    }
    
    
}