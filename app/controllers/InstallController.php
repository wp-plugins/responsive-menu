<?php

class InstallController extends BaseController {
    
    
    public function install() {

        
        add_option( 'RMVer', Registry::get( 'config', 'current_version' ) );
        add_option( 'RMOptions', Registry::get( 'defaults' ) );

        
    }
    
    
}