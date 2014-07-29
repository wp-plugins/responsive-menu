<?php


class HTMLController extends BaseController {
    
    
    function display() {
        
         
        View::make( 'menu', Registry::get( 'options' ) );
     
        
    }
    
    
}