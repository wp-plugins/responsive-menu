<?php

class View {
    
    
    public function make( $page, $data ) {
        
        $page = str_replace( '.', '/', $page );
        
        require Registry::get( 'config', 'plugin_base_dir' ) . '/app/views/' . $page . '.phtml';
        
    }
    
    
}