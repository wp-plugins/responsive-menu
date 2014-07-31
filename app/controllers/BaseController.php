<?php

class BaseController {
    
    
    /**
     * Determines wether to display scripts in footer
     *
     * @return boolean
     * @added 2.0
     */
    
    function inFooter() {
           
        
        return Registry::get( 'options', 'RMFooter' ) && Registry::get( 'options', 'RMFooter' ) == 'footer' ?  true : false;
        
        
    }
    
    
}