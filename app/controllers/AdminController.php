<?php


class RM_AdminController extends RM_BaseController {
    
        
    /**
     * Prepare our Admin Options
     *
     * @return null
     * @added 2.0
     */
    
    static function prepare() {
        
        add_action( 'admin_menu', array( 'RM_AdminController', 'addMenus' ) );
        add_action( 'admin_enqueue_scripts', array( 'RM_AdminController', 'colorpicker' ) );
        add_filter( 'plugin_action_links', array( 'RM_AdminController', 'addSettingsLink' ), 10, 2 );
        
    }
    
    
    /**
     * Create our admin menus.
     *
     * @return null
     * @added 1.0
     */
    
    static function addMenus() {

        
        add_menu_page( 

            __( 'Responsive Menu', 'responsive-menu' ), 
            __( 'Responsive Menu', 'responsive-menu' ), 
            'manage_options', 
            'responsive-menu', 
            array( 'RM_AdminController', 'adminPage' ), 
            RM_Registry::get( 'config', 'plugins_base_uri' ) . 'public/imgs/icon.png' 

        );

        
    }
    
    /**
     * Creates the main admin page and saves the data if submitted
     *
     * @return null
     * @added 1.0
     */
    
    static function adminPage() {
        
        
        if( RM_Input::post( 'RMSubmit' ) ) :
            
            RM_AdminModel::save( RM_Input::post() );
        
            if( RM_Registry::get( 'options', 'RMExternal' ) ) : 
                
                
                RM_FolderModel::create();
            
            
                $js = RM_JSModel::getJs( 'strip_tags' );        
                $js = RM_Registry::get( 'options', 'RMMinify') == 'minify' ? RM_JSModel::Minify( $js ) : $js = $js;        
                RM_JSModel::createJSFile( $js );
            
                
                $css = RM_CSSModel::getCSS( 'strip_tags' );
                $css = RM_CSSModel::Minify( $css );
                RM_CSSModel::createCSSFile( $css );

                
            endif;
                
        
        endif;    

        RM_View::make( 'admin.page', RM_Registry::get( 'options' ) );
        
        
    }
    
    /**
     * Adds the WordPress Colour Picker to the admin options page
     *
     * @return null
     * @added 1.0
     */
    
    static function colorpicker(){ 
    
        
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );

        
    }
    
        
    /**
     * Adds the settings link on the WordPress Plugins Page
     *
     * @param array $links
     * @param string $file
     * @return array
     * @added 2.0
     */
    
    static function addSettingsLink( $links, $file ) {
        
        
        if ( $file == 'responsive-menu/responsive-menu.php' ) :

            $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=responsive-menu">';
            $settings_link .= __( 'Settings', 'responsive-menu' );
            $settings_link .= '</a>';
            
            array_unshift( $links, $settings_link );

        endif;

        return $links;

    
    }

    
}