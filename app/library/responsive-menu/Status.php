<?php

class Status {
    
    protected static $status = array();
    
    function set( $type, $text ) {
        
        
        array_push( self::$status, array( $type, $text ) );

        
    }
    
    
    function get() {
        
        
        return self::$status;
        
        
    }
    
    
}