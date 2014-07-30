<?php

class UpgradeController extends BaseController {
    
    
    function upgrade() {
        
        if( self::needsUpgrade() ) :
            

            update_option( 'RMVer', Registry::get( 'config', 'current_version' ) );
            
        
        endif;

            
    }
    
    
    function needsUpgrade() {
        
        
        return get_option( 'RMVer' ) != Registry::get( 'config', 'current_version' ) ? true : false;

        
    }
    
    
}