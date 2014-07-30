<?php

class GlobalController extends BaseController {
    
    
    function jQuery() {
        
        wp_enqueue_script( 'jquery' );
        
    }
    
    
    function Internationalise() {

        load_plugin_textdomain( 'responsive-menu', false, Registry::get( 'config', 'plugin_base_dir' ) . '/translations/' );

    }
    
    
}