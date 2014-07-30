<?php

class View {
    
    
    function make( $page, $data ) {
        
        
        $page = str_replace( '.', '/', $page );
        
        require Registry::get( 'config', 'plugin_base_dir' ) . '/app/views/' . $page . '.phtml';
        
        
    }
    
    function checkViewPortTag() {

        
        $metaTags = get_meta_tags( get_bloginfo( 'url' ) );

        if ( $metaTags['viewport'] )
            return $metaTags['viewport'];
        
        
    }
    
    function statusBar( $status ) {

        
        $message = null;        
        
        foreach( $status as $stati ) :
            
            $message .= '<div id="message" class="' . $stati[0] . ' below-h2 cookieBannerSuccess">';
            $message .= '<p>' . $stati[1] . '</p>';
            $message .= '</div>';

        endforeach;

        return $message;
                    
    }
    
    
}