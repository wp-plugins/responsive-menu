<?php

class Registry {
    
    public static function getConfig( $option ) {
        
        return $config[$option];
        
    }
    
    public static function getDefault( $option ) {
        
        return $defaults[$option];
        
    }
    
    public static function get( $array, $option ) {
        
        return $$array[$option];
        
    }
    
}