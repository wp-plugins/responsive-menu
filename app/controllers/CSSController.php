<?php


class CSSController extends BaseController {
    
    
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
    
    function addInline() {
        
        if( Registry::get( 'options', 'RMMinify' ) == 'minify' ) 
            echo CSSModel::Minify( CSSModel::getCSS() ); 
        else 
            echo CSSModel::getCSS(); 
        
    }
    
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