<?php

class UpgradeController extends BaseController {
    
      
    /**
     * Script that runs if the menu has been upgraded
     *
     * @return mixed
     * @added 2.0
     */
    
    function upgrade() {
        
        
        if( self::needsUpgrade() ) :
            

            update_option( 'RMVer', Registry::get( 'config', 'current_version' ) );
            
        
        endif;

            
    }
    
        
    /**
     * Determines whether or not the site needs upgrading
     *
     * @return boolean
     * @added 2.0
     */
    
    function needsUpgrade() {
        
        
        return get_option( 'RMVer' ) != Registry::get( 'config', 'current_version' ) ? true : false;

        
    }
    
    
}