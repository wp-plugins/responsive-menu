<?php

class RM_UpgradeController extends RM_BaseController {
    
      
    /**
     * Script that runs if the menu has been upgraded
     *
     * @return mixed
     * @added 2.0
     */
    
    static function upgrade() {
        
        
        if( self::needsUpgrade() ) :
            

            update_option( 'RMVer', RM_Registry::get( 'config', 'current_version' ) );
            
        
        endif;

            
    }
    
        
    /**
     * Determines whether or not the site needs upgrading
     *
     * @return boolean
     * @added 2.0
     */
    
    static function needsUpgrade() {
        
        
        return get_option( 'RMVer' ) != RM_Registry::get( 'config', 'current_version' ) ? true : false;

        
    }
    
    
}