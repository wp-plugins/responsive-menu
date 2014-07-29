<?php

$config = array( 
    
    
    'current_version' => 1.10,
    
    
    'plugins_dir' => plugin_dir_path( __FILE__ ),
        
    
    'plugins_base_uri' => plugin_dir_url( dirname( __FILE__ ) ),
    
    
    'plugin_base_dir' => dirname( plugin_dir_path( __FILE__ ) ),
    
    
    'plugin_data_uri' => plugin_dir_url( dirname( __FILE__ ) ) . 'responsive-menu-data/',
    
    
    'plugin_data_dir' => dirname( plugin_dir_path( __FILE__ ) ) . '/responsive-menu-data/',
    
    
);



$defaults = array( 
    
    
    'RM' => '',
    
    
    'RMBreak' => 600,
    
    
    'RMDepth' => 2,
    
    
    'RMTop' => 10,
    
    
    'RMRight' => 5,
    
    
    'RMCss' => '',
    
    
    'RMTitle' => __( 'Menu Title', 'responsive-menu' ),
    
    
    'RMLineCol' => '#FFFFFF',
    
    
    'RMClickBkg' => '#000000',
    
    
    'RMClickTitle' => '',
    
    
    'RMBkgTran' => 'checked',
    
    
    'RMFont' => '',
    
    
    'RMPos' => '',
    
    
    'RMImage' => '',
    
    
    'RMWidth' => '75',
    
    
    'RMBkg' => '#43494C',
    
    
    'RMBkgHov' => '#3C3C3C',
    
    
    'RMTitleCol' => '#FFFFFF',
    
    
    'RMTextCol' => '#FFFFFF',
    
    
    'RMBorCol' => '#3C3C3C',
    
    
    'RMTextColHov' => '#FFFFFF',
    
    
    'RMTitleColHov' => '#FFFFFF',

    
    /* Added in 1.6 */
    
    
    'RMAnim' => 'overlay',
    
    
    'RMPushCSS' => '',
    
    
    'RMTitleBkg' => '#43494C',
    
    
    'RMFontSize' => 13,
    
    
    'RMTitleSize' => 14,
    
    
    'RMBtnSize' => 13,
    
    
    'RMCurBkg' => '#43494C',
    
    
    'RMCurCol' => '#FFFFFF',
    
    
    'RMAnimSpd' => 0.5,

    
    /* Added in 1.7 */
    
    
    'RMTranSpd' => 1,
    
    
    'RMTxtAlign' => 'left',
    
    
    'RMSearch' => false,
    
    
    'RMExpand' => false,
    
    
    'RMLinkHeight' => 20,

    
    /* Added in 1.8 */
    
    
    'RMExternal' => false,
    
    
    'RMSide' => 'left',

    
    /* Added in 1.9 */
    
    
    'RMFooter' => false,
    
    
    'RMClickImg' => false,
    
    
    'RMMinify' => false,
    
    
    'RMClickClose' => false,
    
    
    'RMRemImp' => false,
    
    
    'RMX' => false,
    
    
    'RMMinWidth' => null

    
);