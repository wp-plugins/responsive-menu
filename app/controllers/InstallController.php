<?php

class InstallController extends BaseController {
    
    
    public function install() {

        add_option( 'RMVer', Registry::getConfig( 'current_version' ) );

        add_option( 'RMOptions', Registry::getDefaults() );

    }
    
}