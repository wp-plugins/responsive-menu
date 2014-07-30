<?php

class BaseController {
    
    function inFooter() {
           
        
        if( Registry::get( 'options', 'RMFooter' ) && Registry::get( 'options', 'RMFooter' ) == 'footer' )
            return true;
        else 
            return false;
        
        
    }
    
    
}