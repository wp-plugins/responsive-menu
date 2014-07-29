<?php

class View {
    
    
    public function make( $page, $data ) {
        
        $page = str_replace( '.', '/', $page );
        
        require Registry::get( 'config', 'plugin_base_dir' ) . '/app/views/' . $page . '.phtml';
        
    }
    
    function checkViewPortTag() {

        $metaTags = get_meta_tags( get_bloginfo( 'url' ) );

        if ( $metaTags['viewport'] )
            return $metaTags['viewport'];
        
    }
    
    
}