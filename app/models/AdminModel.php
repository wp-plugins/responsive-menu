<?php

class AdminModel extends BaseModel {
    
    
    public function save( $data ) {
    
        
        // Initialise Variables Correctly
        
        $RM = isset($_POST['RM']) ? $_POST['RM'] : Registry::get( 'defaults', 'RM' );
        
        $RMTitle = isset($_POST['RMTitle']) ? $_POST['RMTitle'] : Registry::get( 'defaults', 'RMTitle' );
        
        $RMBreak = isset($_POST['RMBreak']) ? $_POST['RMBreak'] : Registry::get( 'defaults', 'RMBreak' );
        
        $RMDepth = isset($_POST['RMDepth']) ? $_POST['RMDepth'] : Registry::get( 'defaults', 'RMDepth' );
        
        $RMTop = isset($_POST['RMTop']) ? $_POST['RMTop'] : Registry::get( 'defaults', 'RMTop' );
        
        $RMRight = isset($_POST['RMRight']) ? $_POST['RMRight'] : Registry::get( 'defaults', 'RMRight' );
        
        $RMCss = isset($_POST['RMCss']) ? $_POST['RMCss'] : Registry::get( 'defaults', 'RMCss' );
        
        $RMLineCol = isset($_POST['RMLineCol']) ? $_POST['RMLineCol'] : Registry::get( 'defaults', 'RMLineCol' );
        
        $RMClickBkg = isset($_POST['RMClickBkg']) ? $_POST['RMClickBkg'] : Registry::get( 'defaults', 'RMClickBkg' );
        
        $RMClickTitle = isset($_POST['RMClickTitle']) ? $_POST['RMClickTitle'] : Registry::get( 'defaults', 'RMClickTitle' );
        
        $RMBkgTran = isset($_POST['RMBkgTran']) ? $_POST['RMBkgTran'] : Registry::get( 'defaults', 'RMBkgTran' );
        
        $RMPos = isset($_POST['RMPos']) ? $_POST['RMPos'] : Registry::get( 'defaults', 'RMPos' );
        
        $RMImage = isset($_POST['RMImage']) ? $_POST['RMImage'] : Registry::get( 'defaults', 'RMImage' );
        
        $RMWidth = isset($_POST['RMWidth']) ? $_POST['RMWidth'] : Registry::get( 'defaults', 'RMWidth' );
        
        $RMBkg = isset($_POST['RMBkg']) ? $_POST['RMBkg'] : Registry::get( 'defaults', 'RMBkg' );
        
        $RMBkgHov = isset($_POST['RMBkgHov']) ? $_POST['RMBkgHov'] : Registry::get( 'defaults', 'RMBkgHov' );
        
        $RMTitleCol = isset($_POST['RMTitleCol']) ? $_POST['RMTitleCol'] : Registry::get( 'defaults', 'RMTitleCol' );
        
        $RMTextCol = isset($_POST['RMTextCol']) ? $_POST['RMTextCol'] : Registry::get( 'defaults', 'RMTextCol' );
        
        $RMBorCol = isset($_POST['RMBorCol']) ? $_POST['RMBorCol'] : Registry::get( 'defaults', 'RMBorCol' );
        
        $RMTextColHov = isset($_POST['RMTextColHov']) ? $_POST['RMTextColHov'] : Registry::get( 'defaults', 'RMTextColHov' );
        
        $RMTitleColHov = isset($_POST['RMTitleColHov']) ? $_POST['RMTitleColHov'] : Registry::get( 'defaults', 'RMTitleColHov' );

        /* Added in 1.6 */
        
        $RMAnim = isset($_POST['RMAnim']) ? $_POST['RMAnim'] : Registry::get( 'defaults', 'RMAnim' );
        
        $RMPushCSS = isset($_POST['RMPushCSS']) ? $_POST['RMPushCSS'] : Registry::get( 'defaults', 'RMPushCSS' );
        
        $RMTitleBkg = isset($_POST['RMTitleBkg']) ? $_POST['RMTitleBkg'] : Registry::get( 'defaults', 'RMTitleBkg' );
        
        $RMFont =  isset($_POST['RMFont']) ? $_POST['RMFont'] : Registry::get( 'defaults', 'RMFont' );
        
        $RMFontSize = isset($_POST['RMFontSize']) ? $_POST['RMFontSize'] : Registry::get( 'defaults', 'RMFontSize' );
        
        $RMTitleSize = isset($_POST['RMTitleSize']) ? $_POST['RMTitleSize'] : Registry::get( 'defaults', 'RMTitleSize' );
        
        $RMBtnSize = isset($_POST['RMBtnSize']) ? $_POST['RMBtnSize'] : Registry::get( 'defaults', 'RMBtnSize' );
        
        $RMCurBkg = isset($_POST['RMCurBkg']) ? $_POST['RMCurBkg'] : Registry::get( 'defaults', 'RMCurBkg' );
        
        $RMCurCol = isset($_POST['RMCurCol']) ? $_POST['RMCurCol'] : Registry::get( 'defaults', 'RMCurCol' );
        
        $RMAnimSpd = isset($_POST['RMAnimSpd']) ? $_POST['RMAnimSpd'] : Registry::get( 'defaults', 'RMAnimSpd' );

        /* Added in 1.7 */
        
        $RMTranSpd = isset($_POST['RMTranSpd']) ? $_POST['RMTranSpd'] : Registry::get( 'defaults', 'RMTranSpd' );
        
        $RMTxtAlign = isset($_POST['RMTxtAlign']) ? $_POST['RMTxtAlign'] : Registry::get( 'defaults', 'RMTxtAlign' );
        
        $RMSearch = isset($_POST['RMSearch']) ? $_POST['RMSearch'] : Registry::get( 'defaults', 'RMSearch' );
        
        $RMExpand = isset($_POST['RMExpand']) ? $_POST['RMExpand'] : Registry::get( 'defaults', 'RMExpand' );
        
        $RMLinkHeight = isset($_POST['RMLinkHeight']) ? $_POST['RMLinkHeight'] : Registry::get( 'defaults', 'RMLinkHeight' );

        /* Added in 1.8 */
        
        $RMExternal = isset( $_POST['RMExternal'] ) ? $_POST['RMExternal'] : Registry::get( 'defaults', 'RMExternal' );
        
        $RMSide = isset( $_POST['RMSide'] ) ? $_POST['RMSide'] : Registry::get( 'defaults', 'RMSide' );

        /* Added in 1.9 */
        
        $RMFooter = isset( $_POST['RMFooter'] ) ? $_POST['RMFooter'] : Registry::get( 'defaults', 'RMFooter' );
        
        $RMClickImg = isset( $_POST['RMClickImg'] ) ? $_POST['RMClickImg'] : Registry::get( 'defaults', 'RMClickImg' );
        
        $RMMinify = isset( $_POST['RMMinify'] ) ? $_POST['RMMinify'] : Registry::get( 'defaults', 'RMMinify' );
        
        $RMClickClose = isset( $_POST['RMClickClose'] ) ? $_POST['RMClickClose'] : Registry::get( 'defaults', 'RMClickClose' );
        
        $RMRemImp = isset( $_POST['RMRemImp'] ) ? $_POST['RMRemImp'] : Registry::get( 'defaults', 'RMRemImp' ); 

        $RMX = isset( $_POST['RMX'] ) ? $_POST['RMX'] : Registry::get( 'defaults', 'RMX' );
        
        $RMMinWidth = isset( $_POST['RMMinWidth'] ) ? $_POST['RMMinWidth'] : Registry::get( 'defaults', 'RMMinWidthRM' );

        $optionsArray = array(
            
            // Filter Input Correctly
            
            'RM' => self::Filter($RM),
            
            'RMBreak' => intval($RMBreak),
            
            'RMDepth' => intval($RMDepth),
            
            'RMTop' => intval($RMTop),
            
            'RMRight' => intval($RMRight),
            
            'RMCss' => self::Filter($RMCss),
            
            'RMTitle' => self::Filter($RMTitle),
            
            'RMLineCol' => self::Filter($RMLineCol),
            
            'RMClickBkg' => self::Filter($RMClickBkg),
            
            'RMClickTitle' => self::Filter($RMClickTitle),
            
            'RMBkgTran' => self::Filter($RMBkgTran),
            
            'RMFont' => self::Filter($RMFont),
            
            'RMPos' => self::Filter($RMPos),
            
            'RMImage' => self::Filter($RMImage),
            
            'RMWidth' => intval($RMWidth),
            
            'RMBkg' => self::Filter($RMBkg),
            
            'RMBkgHov' => self::Filter($RMBkgHov),
            
            'RMTitleCol' => self::Filter($RMTitleCol),
            
            'RMTextCol' => self::Filter($RMTextCol),
            
            'RMBorCol' => self::Filter($RMBorCol),
            
            'RMTextColHov' => self::Filter($RMTextColHov),
            
            'RMTitleColHov' => self::Filter($RMTitleColHov),

            /* Added in 1.6 */
            
            'RMAnim' => self::Filter($RMAnim),
            
            'RMPushCSS' => self::Filter($RMPushCSS),
            
            'RMTitleBkg' => self::Filter( $RMTitleBkg ),
            
            'RMFontSize' => intval( $RMFontSize ),
            
            'RMTitleSize' => intval( $RMTitleSize ),
            
            'RMBtnSize' => intval( $RMBtnSize ),
            
            'RMCurBkg' => self::Filter( $RMCurBkg ),
            
            'RMCurCol' => self::Filter( $RMCurCol ),
            
            'RMAnimSpd' => floatval( $RMAnimSpd ),

            /* Added in 1.7 */
            
            'RMTranSpd' => floatval( $RMTranSpd ),
            
            'RMTxtAlign' => self::Filter( $RMTxtAlign ),
            
            'RMSearch' => self::Filter( $RMSearch ),
            
            'RMExpand' => self::Filter( $RMExpand ),    
            
            'RMLinkHeight' => intval( $RMLinkHeight ),

            /* Added in 1.8 */
            
            'RMExternal' => self::Filter( $RMExternal ),
            
            'RMSide' => self::Filter( $RMSide ),

            /* Added in 1.9 */
            
            'RMFooter' => self::Filter( $RMFooter ),    
            
            'RMClickImg' => self::Filter( $RMClickImg ),
            
            'RMMinify' => self::Filter( $RMMinify ),
            
            'RMClickClose' => self::Filter( $RMClickClose ),
            
            'RMRemImp' => self::Filter( $RMRemImp ),
            
            'RMX' => self::Filter( $RMX ),
            
            'RMMinWidth' => intval( $RMMinWidth )

        );

        // Update Submitted Options 
        
        update_option( 'RMOptions', $optionsArray );
            
        // And save back to the registry 
        
        Registry::set( 'options', $optionsArray );

        
    }
    
    
}