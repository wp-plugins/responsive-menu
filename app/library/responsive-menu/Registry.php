<?php

class Registry {
    
    public static function getConfig( $option ) {
        
        return $config[$option];
        
    }
    
    public static function getDefault( $option ) {
        
        return $defaults[$option];
        
    }
    
}