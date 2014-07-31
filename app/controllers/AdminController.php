<?php


class AdminController extends BaseController {
    
    /**
     * Create our admin menus.
     *
     * @return null
     * @added 1.0
     */
    
    function addMenus() {

        
        add_menu_page( 

            __( 'Responsive Menu', 'responsive-menu' ), 
            __( 'Responsive Menu', 'responsive-menu' ), 
            'manage_options', 
            'responsive-menu', 
            array( 'AdminController', 'adminPage' ), 
            Registry::get( 'config', 'plugins_base_uri' ) . 'public/imgs/icon.png' 

        );

        
    }
    
    /**
     * Creates the main admin page and saves data
     *
     * @return null
     * @added 1.0
     */
    
    function adminPage() {
        
        
        if( isset( $_POST['RMSubmit'] ) ) :
            
            AdminModel::save( $_POST );
        
            if( Registry::get( 'options', 'RMExternal' ) ) : 
                
                FolderModel::create();
            
            endif;
        
        endif;    

        View::make( 'admin.page', Registry::get( 'options' ) );
        
        
    }
    
    /**
     * Adds the WordPress Colour Picker to the admin options page
     *
     * @return null
     * @added 1.0
     */
    
    function colorpicker(){ 
    
        
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );

        
    }
    
    
}