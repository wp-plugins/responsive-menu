<?php

class View {
    
        
    /**
     * Create a new view for display throughout the application
     * Users .phtml files found in the app/views folder
     *
     * @param  string  $page
     * @param mixed $data
     * @return null
     * @added 2.0
     */
    
    function make( $page, $data ) {
        
        
        $page = str_replace( '.', '/', $page );
        
        require Registry::get( 'config', 'plugin_base_dir' ) . '/app/views/' . $page . '.phtml';
        
        
    }
    
    
    /**
     * Function to Check the current View Port Tag on the site
     *
     * @return string
     * @added 2.0
     */
    
    function checkViewPortTag() {

        
        $metaTags = get_meta_tags( get_bloginfo( 'url' ) );

        if ( $metaTags['viewport'] )
            return $metaTags['viewport'];
        
        
    }
    
    
    /**
     * Function to format and display the status bar in the admin pages
     *
     * @param  array  $status
     * @return string
     * @added 2.0
     */
    
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