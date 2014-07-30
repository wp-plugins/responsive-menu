<?php

class AdminModel extends BaseModel {
    
    
    public function save( $data ) {
    
        
        // Initialise Variables Correctly
        
        $RM = isset($data['RM']) ? $data['RM'] : Registry::get( 'defaults', 'RM' );
        
        $RMTitle = isset($data['RMTitle']) ? $data['RMTitle'] : Registry::get( 'defaults', 'RMTitle' );
        
        $RMBreak = isset($data['RMBreak']) ? $data['RMBreak'] : Registry::get( 'defaults', 'RMBreak' );
        
        $RMDepth = isset($data['RMDepth']) ? $data['RMDepth'] : Registry::get( 'defaults', 'RMDepth' );
        
        $RMTop = isset($data['RMTop']) ? $data['RMTop'] : Registry::get( 'defaults', 'RMTop' );
        
        $RMRight = isset($data['RMRight']) ? $data['RMRight'] : Registry::get( 'defaults', 'RMRight' );
        
        $RMCss = isset($data['RMCss']) ? $data['RMCss'] : Registry::get( 'defaults', 'RMCss' );
        
        $RMLineCol = isset($data['RMLineCol']) ? $data['RMLineCol'] : Registry::get( 'defaults', 'RMLineCol' );
        
        $RMClickBkg = isset($data['RMClickBkg']) ? $data['RMClickBkg'] : Registry::get( 'defaults', 'RMClickBkg' );
        
        $RMClickTitle = isset($data['RMClickTitle']) ? $data['RMClickTitle'] : Registry::get( 'defaults', 'RMClickTitle' );
        
        $RMBkgTran = isset($data['RMBkgTran']) ? $data['RMBkgTran'] : Registry::get( 'defaults', 'RMBkgTran' );
        
        $RMPos = isset($data['RMPos']) ? $data['RMPos'] : Registry::get( 'defaults', 'RMPos' );
        
        $RMImage = isset($data['RMImage']) ? $data['RMImage'] : Registry::get( 'defaults', 'RMImage' );
        
        $RMWidth = isset($data['RMWidth']) ? $data['RMWidth'] : Registry::get( 'defaults', 'RMWidth' );
        
        $RMBkg = isset($data['RMBkg']) ? $data['RMBkg'] : Registry::get( 'defaults', 'RMBkg' );
        
        $RMBkgHov = isset($data['RMBkgHov']) ? $data['RMBkgHov'] : Registry::get( 'defaults', 'RMBkgHov' );
        
        $RMTitleCol = isset($data['RMTitleCol']) ? $data['RMTitleCol'] : Registry::get( 'defaults', 'RMTitleCol' );
        
        $RMTextCol = isset($data['RMTextCol']) ? $data['RMTextCol'] : Registry::get( 'defaults', 'RMTextCol' );
        
        $RMBorCol = isset($data['RMBorCol']) ? $data['RMBorCol'] : Registry::get( 'defaults', 'RMBorCol' );
        
        $RMTextColHov = isset($data['RMTextColHov']) ? $data['RMTextColHov'] : Registry::get( 'defaults', 'RMTextColHov' );
        
        $RMTitleColHov = isset($data['RMTitleColHov']) ? $data['RMTitleColHov'] : Registry::get( 'defaults', 'RMTitleColHov' );

        /* Added in 1.6 */
        
        $RMAnim = isset($data['RMAnim']) ? $data['RMAnim'] : Registry::get( 'defaults', 'RMAnim' );
        
        $RMPushCSS = isset($data['RMPushCSS']) ? $data['RMPushCSS'] : Registry::get( 'defaults', 'RMPushCSS' );
        
        $RMTitleBkg = isset($data['RMTitleBkg']) ? $data['RMTitleBkg'] : Registry::get( 'defaults', 'RMTitleBkg' );
        
        $RMFont =  isset($data['RMFont']) ? $data['RMFont'] : Registry::get( 'defaults', 'RMFont' );
        
        $RMFontSize = isset($data['RMFontSize']) ? $data['RMFontSize'] : Registry::get( 'defaults', 'RMFontSize' );
        
        $RMTitleSize = isset($data['RMTitleSize']) ? $data['RMTitleSize'] : Registry::get( 'defaults', 'RMTitleSize' );
        
        $RMBtnSize = isset($data['RMBtnSize']) ? $data['RMBtnSize'] : Registry::get( 'defaults', 'RMBtnSize' );
        
        $RMCurBkg = isset($data['RMCurBkg']) ? $data['RMCurBkg'] : Registry::get( 'defaults', 'RMCurBkg' );
        
        $RMCurCol = isset($data['RMCurCol']) ? $data['RMCurCol'] : Registry::get( 'defaults', 'RMCurCol' );
        
        $RMAnimSpd = isset($data['RMAnimSpd']) ? $data['RMAnimSpd'] : Registry::get( 'defaults', 'RMAnimSpd' );

        /* Added in 1.7 */
        
        $RMTranSpd = isset($data['RMTranSpd']) ? $data['RMTranSpd'] : Registry::get( 'defaults', 'RMTranSpd' );
        
        $RMTxtAlign = isset($data['RMTxtAlign']) ? $data['RMTxtAlign'] : Registry::get( 'defaults', 'RMTxtAlign' );
        
        $RMSearch = isset($data['RMSearch']) ? $data['RMSearch'] : Registry::get( 'defaults', 'RMSearch' );
        
        $RMExpand = isset($data['RMExpand']) ? $data['RMExpand'] : Registry::get( 'defaults', 'RMExpand' );
        
        $RMLinkHeight = isset($data['RMLinkHeight']) ? $data['RMLinkHeight'] : Registry::get( 'defaults', 'RMLinkHeight' );

        /* Added in 1.8 */
        
        $RMExternal = isset( $data['RMExternal'] ) ? $data['RMExternal'] : Registry::get( 'defaults', 'RMExternal' );
        
        $RMSide = isset( $data['RMSide'] ) ? $data['RMSide'] : Registry::get( 'defaults', 'RMSide' );

        /* Added in 1.9 */
        
        $RMFooter = isset( $data['RMFooter'] ) ? $data['RMFooter'] : Registry::get( 'defaults', 'RMFooter' );
        
        $RMClickImg = isset( $data['RMClickImg'] ) ? $data['RMClickImg'] : Registry::get( 'defaults', 'RMClickImg' );
        
        $RMMinify = isset( $data['RMMinify'] ) ? $data['RMMinify'] : Registry::get( 'defaults', 'RMMinify' );
        
        $RMClickClose = isset( $data['RMClickClose'] ) ? $data['RMClickClose'] : Registry::get( 'defaults', 'RMClickClose' );
        
        $RMRemImp = isset( $data['RMRemImp'] ) ? $data['RMRemImp'] : Registry::get( 'defaults', 'RMRemImp' ); 

        $RMX = isset( $data['RMX'] ) ? $data['RMX'] : Registry::get( 'defaults', 'RMX' );
        
        $RMMinWidth = isset( $data['RMMinWidth'] ) ? $data['RMMinWidth'] : Registry::get( 'defaults', 'RMMinWidthRM' );

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