<?php


class JSController extends BaseController {
    
        
    /**
     * Prepare our JavaScript for inclusion throughout the site
     *
     * @return null
     * @added 1.0
     */
    
    function prepare() {

        
        if( Registry::get( 'options', 'RMExternal' ) ) :

            
            $js = JSModel::getJs( 'strip_tags' );
        
            $js = Registry::get( 'options', 'RMMinify') == 'minify' ? JSModel::Minify( $js ) : $js = $js;
        
            JSModel::createJSFile( $js );

            add_action( 'wp_enqueue_scripts', array( 'JSController', 'addExternal' ) );
 
        
        else :

            
            $inFooter = self::inFooter() ? 'wp_footer' : 'wp_head';
        
            add_action( $inFooter, array( 'JSController', 'addInline' ) ); 
               
            
        endif;
        
        
    }
    
        
    /**
     * Creates and echos the inline styles if used
     *
     * @return string
     * @added 1.0
     */
    
    function addInline() {
        
        
        echo Registry::get( 'options', 'RMMinify' ) == 'minify' ? JSModel::Minify( JSModel::getJs() ) : JSModel::getJs();
            
        
    }
    
        
    /**
     * Adds the external scripts to the site if required
     *
     * @return null
     * @added 1.4
     */
    
    function addExternal() {
        
        
        wp_enqueue_script( 

            'responsive-menu', 
            Registry::get( 'config', 'plugin_data_uri' ) . 'js/responsive-menu-' . get_current_blog_id() . '.js', 
            'jquery', 
            '1.0', 
            self::inFooter() 

        );
             
        
    }
    
    
}