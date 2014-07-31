<?php

class InstallController extends BaseController {
    
        
    /**
     * Sets our initial default options when menu
     * is first installed
     *
     * @return null
     * @added 1.0
     */
    
    public function install() {

        
        add_option( 'RMVer', Registry::get( 'config', 'current_version' ) );
        add_option( 'RMOptions', Registry::get( 'defaults' ) );

        
    }
    
    
}