<?php


class CSSController extends BaseController {
    
    
    /**
     * Prepare our CSS Outputs
     *
     * @return null
     * @added 2.0
     */
    
    function prepare() {
        
        
        if( Registry::get( 'options', 'RMExternal' ) ) :

            
            $css = CSSModel::getCSS( 'strip_tags' );

        
            if( Registry::get( 'options', 'RMMinify') == 'minify' )
                    $css = CSSModel::Minify( $css );
            
            
            CSSModel::createCSSFile( $css );
            
            
            add_action( 'wp_enqueue_scripts', array( 'CSSController', 'addExternal' ) );
            
            
        else :
                
            
            add_action( 'wp_head', array( 'CSSController', 'addInline' ) ); 

        
        endif;   


    }
    
    
    /**
     * Create and echos the Inline Styles
     *
     * @return string
     * @added 2.0
     */
    
    function addInline() {
        
        
        echo Registry::get( 'options', 'RMMinify' ) == 'minify' ? CSSModel::Minify( CSSModel::getCSS() ) : CSSModel::getCSS(); 
        
        
    }
    
    
    /**
     * Adds External Styles to Header
     *
     * @return null
     * @added 2.0
     */
    
    function addExternal() {
        
        
        wp_enqueue_style( 
            'responsive-menu', 
            Registry::get( 'config', 'plugin_data_uri' ) . 'css/responsive-menu-' . get_current_blog_id() . '.css', 
            array(), 
            '1.0', 
            'all' 
        ); 
               
        
    }
    

}