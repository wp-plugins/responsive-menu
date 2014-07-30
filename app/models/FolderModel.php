<?php

class FolderModel extends BaseModel {
    
    
    static function create() {

        
        $mainFolder = Registry::get( 'config', 'plugin_data_dir' );
        $cssFolder  = Registry::get( 'config', 'plugin_data_dir' ) . '/css';
        $jsFolder   = Registry::get( 'config', 'plugin_data_dir' ) . '/js';
        

        if( !file_exists( $mainFolder ) ) mkdir( $mainFolder, 0777 );
        if( !file_exists( $cssFolder ) ) mkdir( $cssFolder, 0777 );
        if( !file_exists( $jsFolder ) ) mkdir( $jsFolder, 0777 ); 

        
        if( !file_exists( $mainFolder ) )
            Status::set( 'error', __( 'Unable to create data folders', 'responsive-menu' ) );
        
        if( !file_exists( $cssFolder ) )
            Status::set( 'error', __( 'Unable to create CSS folders', 'responsive-menu' ) );
        
        if( !file_exists( $cssFolder ) )
            Status::set( 'error', __( 'Unable to create JS folders', 'responsive-menu' ) );
        
        
    }
    

}