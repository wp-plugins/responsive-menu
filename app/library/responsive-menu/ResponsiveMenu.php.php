<?php

class ResponsiveMenu {
    
    protected $options;
    protected $version;
    
    public function __construct() {
        
        $this->options = !is_array( get_option( 'RMOptions' ) ) ? unserialize( get_option( 'RMOptions' ) ) :  get_option( 'RMOptions' );
        $this->version = get_option( 'RMVer' );
        
    }
    
    public function run() {
        
        
    }
    
}