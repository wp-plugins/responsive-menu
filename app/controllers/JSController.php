<?php


class JSController extends BaseController {
    
    
    function prepare() {

        if( Registry::get( 'options', 'RMExternal' ) ) :

            $js = JSModel::getJs( 'strip_tags' );
        
            if( Registry::get( 'options', 'RMMinify') == 'minify' )
                $js = JSModel::Minify( $js );
        
            JSModel::createJSFile( $js );

            add_action( 'wp_enqueue_scripts', array( 'JSController', 'addExternal' ) );
 
        
        else :

            $inFooter = self::inFooter() ? 'wp_footer' : 'wp_head';
            add_action( $inFooter, array( 'JSController', 'addInline' ) ); 
               
        endif;   
        
     
        
    }
    
    function addInline() {
        
        if( Registry::get( 'options', 'RMMinify' ) == 'minify' )
            echo JSModel::Minify( JSModel::getJs() );
        else 
            echo JSModel::getJs();
            
    }
    
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