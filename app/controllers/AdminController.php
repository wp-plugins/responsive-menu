<?php


class AdminController extends BaseController {
    
    
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
    
    
    function adminPage() {
        
        if( isset( $_POST['RMSubmit'] ) )
            AdminModel::save( $_POST );
            
        View::make( 'admin.page', Registry::get( 'options' ) );
        
    }
    
    
    function Colorpicker(){ 
    
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );

    }
    
    
}