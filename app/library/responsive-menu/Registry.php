<?php

class Registry {
    
    
    static $registry;
    
    
    public static function get( $array, $val = null ) {
        
        if( !$val )
            return self::$registry[$array];
        else
            return self::$registry[$array][$val];
        
    }
    
    
    public static function set( $key, $val ) {
        
        self::$registry[$key] = $val;
        
    }
   
    
}