<?php

class RM_JSModel extends RM_BaseModel {
    
    
    /**
     * Function to create the file to hold the JS file
     *
     * @param string $js
     * @return file
     * @added 1.6
     */
    
    static function createJSFile( $js ) {

        
        $file = fopen( RM_Registry::get( 'config', 'plugin_data_dir' ) . '/js/responsive-menu-' . get_current_blog_id() . '.js', 'w' );
        
        $jsFile = fwrite( $file, $js );
        
        fclose( $file );
        
        if( !$file ) 
            RM_Status::set( 'error', __( 'Unable to create JS file', 'responsive-menu' ) );
                
        return $jsFile;
        
        
    }  
    
    
    /**
     * Function to format, create and get the JS itself
     *
     * @param string $args
     * @return string
     * @added 1.0
     */
    
    static function getJS( $args = null ) {

        $options = RM_Registry::get( 'options' );

        $setHeight = $options['RMPos'] == 'fixed' ? '' : " \$RMjQuery( '#responsive-menu' ).css( 'height', \$RMjQuery( document ).height() ); ";
        $breakpoint = empty($options['RMBreak']) ? "600" : $options['RMBreak'];
        
        $RMPushCSS = empty($options['RMPushCSS']) ? "" : $options['RMPushCSS'];

        $slideOpen = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " \$RMjQuery( 'body' ).addClass( 'RMPushOpen' ); " : '';
        $slideRemove = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " \$RMjQuery( 'body' ).removeClass( 'RMPushOpen' ); " : '';

        /* Added 1.8 */
        switch( $options['RMSide'] ) :
            case 'left' : $side = 'left'; break;
            case 'right' : $side = 'right'; break;
            case 'top' : $side = 'top'; break;
            case 'bottom' : $side = 'top'; break;
            default : $side = 'left'; break;
        endswitch;
                
        /* Added 2.0 */
        switch( $options['RMSide'] ) :
            case 'left' : $width = $options['RMWidth']; $neg = '-'; break;
            case 'right' : $width = $options['RMWidth']; $neg = '-'; break;
            case 'top' : $width = '100'; $neg = '-'; break;
            case 'bottom' : $width = '100'; $neg = ''; break;
            default : $width = '75'; break;
        endswitch;
        
        switch( $options['RMSide']  ) :
            case 'left' : $pushSide = 'left'; $pos = ''; break;
            case 'right' : $pushSide = 'left'; $pos = '-'; break;
            case 'top' : $pushSide = 'top'; $pos = ''; break;
            case 'bottom' : $pushSide = 'top'; $pos = '-'; break;
        endswitch;

        $sideSlideOpen = $side == 'right' && empty( $slideOpen ) ? " \$RMjQuery( 'body' ).addClass( 'RMPushOpen' ); " : '';
        $sideSlideRemove =  $side == 'right' && empty( $slideRemove ) ? " \$RMjQuery( 'body' ).removeClass( 'RMPushOpen' ); " : '';
        

        $slideOver = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " \$RMjQuery( '$RMPushCSS' ).animate( { $pushSide: \"{$pos}{$width}%\" }, 500, 'linear' ); " : '';
        
        $slideOverCss = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " \$RMjQuery( '$RMPushCSS' ).addClass( 'RMPushSlide' ); " : '';

        $slideBack = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " \$RMjQuery( '$RMPushCSS' ).animate( { $pushSide: \"0\" }, 500, 'linear' ); " : '';
        
        $slideOverCssRemove = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " \$RMjQuery( '$RMPushCSS' ).removeClass( 'RMPushSlide' ); " : '';

        $speed = empty( $options['RMAnimSpd'] ) ? 500 : $options['RMAnimSpd'] * 1000;
        
        if( $options['RMX'] ) : 
        
            $closeX = " \$RMjQuery( '#click-menu #RMX' ).css( 'display', 'none' );
                        \$RMjQuery( '#click-menu #RM3Lines' ).css( 'display', 'inline' ); ";
        
            $showX = " \$RMjQuery( '#click-menu #RM3Lines' ).css( 'display', 'none' );
                         \$RMjQuery( '#click-menu #RMX' ).css( 'display', 'inline' ); ";        
        else :
        
            $closeX = "";
            $showX = "";
        
        endif;
            
        /* Added 2.0 to stop clicks on the main parent items */
        
        $parentClick = "";
        
        if( $options['RMIgnParCli'] ) :
            
            $parentClick = "
                
                \$RMjQuery( '#responsive-menu .responsive-menu > li.menu-item-has-children' ).children( 'a' ).on( 'click', function( e ) {
                    e.preventDefault();
                });";

        endif;
        
        /* Added 2.0 to automatically expand children links of parents */
        
        $expandChildren = "";
        
        if( $options['RMExpandPar'] ) :
            
            $expandChildren = "
                
                \$RMjQuery( '#responsive-menu .responsive-menu .current_page_ancestor.menu-item-has-children' ).children( 'ul' ).css( 'display', 'block' );
                \$RMjQuery( '#responsive-menu .responsive-menu .current-menu-ancestor.menu-item-has-children' ).children( 'ul' ).css( 'display', 'block' );
                \$RMjQuery( '#responsive-menu .responsive-menu .current-menu-item.menu-item-has-children' ).children( 'ul' ).css( 'display', 'block' );

            ";
                
        endif;
        
        /* Added 2.0 to close menu on page clicks */
    
        $clickToClose = $options['RMCliToClo'] ? "\$RMjQuery( document ).on( 'click tap', function( e ) { if( !\$RMjQuery( e.target ).closest( '#responsive-menu, #click-menu' ).length ) { closeRM(); } } );" : "";

        $js = '';
        
        if( $args != 'strip_tags' ) : 

            $js .= "<script> ";
        
        endif;
        
        $js .= "

            var \$RMjQuery = jQuery.noConflict();

            \$RMjQuery( document ).ready( function( ) {
            
                $parentClick
                $clickToClose
                    
                var isOpen = false;

                \$RMjQuery( document ).on( 'click', '#click-menu', function() {
                       
                    $setHeight

                    if( !isOpen ) {

                         openRM();

                    } else {

                        closeRM();

                    }

                });
                    
                function openRM() {

                      $slideOpen  
                      $sideSlideOpen
                      $slideOverCss
                      $slideOver
                      $showX
                          
                      \$RMjQuery( '#responsive-menu' ).css( 'display', 'block' ); 
                      \$RMjQuery( '#responsive-menu' ).addClass( 'RMOpened' );  
                      
                      \$RMjQuery( '#responsive-menu' ).stop().animate( { $side: \"0\" }, $speed, 'linear', function() { 
                          
                        $setHeight
    
                        isOpen = true;

                      } ); 
                      
                }
   
                function closeRM() {

                        $slideBack
                        
                        \$RMjQuery( '#responsive-menu' ).animate( { $side: \"{$neg}{$width}%\" }, $speed, 'linear', function() { 
                      
                            $slideRemove
                            $sideSlideRemove
                            $slideOverCssRemove
                            $closeX
                            \$RMjQuery( '#responsive-menu' ).css( 'display', 'none' );  
                            \$RMjQuery( '#responsive-menu' ).removeClass( 'RMOpened' );  

                            isOpen = false;

                        } );
                        
                }
                
                \$RMjQuery( window ).resize( function() { 
                
                    $setHeight

                    if( \$RMjQuery( window ).width() > $breakpoint ) { 

                        if( \$RMjQuery( '#responsive-menu' ).css( '$side' ) != '-{$width}%' ) {
                            
                            closeRM();

                        }

                    }

                });

            ";
        
    /* Added 1.7 */
    if ( !$options['RMExpand'] ) : 

        $clickLink = '<span class=\"appendLink\">&#9660;</span>';
        $clickedLink = '<span class=\"appendLink\">&#9650;</span>';
    
        $js .= "clickLink = '{$clickLink}';";
    
        if( $options['RMExpandPar'] ) :
            
            $js .= "clickedLink = '{$clickedLink}';";

        else :
            
            $js .= "clickedLink = '{$clickLink}';";
        
        endif;
                
                
                
                $js .= "\$RMjQuery( '#responsive-menu .responsive-menu .sub-menu' ).css( 'display', 'none' );
    
                \$RMjQuery( '#responsive-menu .responsive-menu .menu-item-has-children' ).not( '.current-menu-item, .current-menu-ancestor, .current_page_ancestor' ).prepend( clickLink );";

                $js .= "\$RMjQuery( '#responsive-menu .responsive-menu .menu-item-has-children.current-menu-item, #responsive-menu .responsive-menu .menu-item-has-children.current_page_ancestor, #responsive-menu .responsive-menu .menu-item-has-children.current-menu-ancestor' ).prepend( clickedLink );";

           
                $js .= "\$RMjQuery( '.appendLink' ).on( 'click', function() { 
                
                    \$RMjQuery( this ).nextAll( 'ul.sub-menu' ).toggle(); 

                    if( \$RMjQuery( this ).html() == '▼' ) {

                        \$RMjQuery( this ).html( '&#9650;' ); 

                    } else {

                        \$RMjQuery( this ).html( '&#9660;' );

                    }

                    $setHeight
    
                } );
                ";

    endif;
    
     /* Added 1.9 */
    if ( isset( $options['RMClickClose'] ) && $options['RMClickClose'] == 'close' ) : 

        $js .= " 
            \$RMjQuery( '#responsive-menu .responsive-menu li a' ).on( 'click', function() { 
            
                closeRM();
            
            } );";

    endif;
    
        $js .= $expandChildren;
    
        $js .= "}); ";

        if( $args != 'strip_tags' ) : 

            $js .= "</script> ";
        
        endif;

        return $js;
            
        
    }
    

}