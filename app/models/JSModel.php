<?php

class JSModel extends BaseModel {
    
    
    function createJSFile( $js ) {

        
        $file = fopen( Registry::get( 'config', 'plugin_data_dir' ) . '/js/responsive-menu-' . get_current_blog_id() . '.js', 'w' );
        
        $jsFile = fwrite( $file, $js );
        
        fclose( $file );
        
        return $jsFile;
        
        
    }  
    
    function getJS( $args = null ) {

        $options = Registry::get( 'options' );

        $setHeight = $options['RMPos'] == 'fixed' ? '' : " \$RMjQuery( '#responsive-menu' ).css( 'height', \$RMjQuery( document ).height() ); ";
        $breakpoint = empty($options['RMBreak']) ? "600" : $options['RMBreak'];
        $width = empty($options['RMWidth']) ? "75" : $options['RMWidth'];
        $RMPushCSS = empty($options['RMPushCSS']) ? "" : $options['RMPushCSS'];

        $slideOpen = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " \$RMjQuery( 'body' ).addClass( 'RMPushOpen' ); " : '';
        $slideRemove = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " \$RMjQuery( 'body' ).removeClass( 'RMPushOpen' ); " : '';

        /* Added 1.8 */
        $side = empty( $options['RMSide'] ) ? 'left' : $options['RMSide']; 
        $pos = $side == 'left' ? '' : '-';

        $sideSlideOpen = $side == 'right' && empty( $slideOpen ) ? " \$RMjQuery( 'body' ).addClass( 'RMPushOpen' ); " : '';
        $sideSlideRemove =  $side == 'right' && empty( $slideRemove ) ? " \$RMjQuery( 'body' ).removeClass( 'RMPushOpen' ); " : '';
        
        $slideOver = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " \$RMjQuery( '$RMPushCSS' ).animate( { left: \"{$pos}{$width}%\" }, 500, 'linear' ); " : '';
        $slideOverCss = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " \$RMjQuery( '$RMPushCSS' ).addClass( 'RMPushSlide' ); " : '';

        $slideBack = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " \$RMjQuery( '$RMPushCSS' ).animate( { left: \"0\" }, 500, 'linear' ); " : '';
        $slideOverCssRemove = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " \$RMjQuery( '$RMPushCSS' ).removeClass( 'RMPushSlide' ); " : '';

        $speed = empty( $options['RMAnimSpd'] ) ? 500 : $options['RMAnimSpd'] * 1000;
        
        if( $options['RMX'] ) : 
        
            $closeX = " \$RMjQuery( '#click-menu #RMX' ).css( 'display', 'none' );
                        \$RMjQuery( '#click-menu #RM3Lines' ).css( 'display', 'block' ); ";
        
            $showX = " \$RMjQuery( '#click-menu #RM3Lines' ).css( 'display', 'none' );
                         \$RMjQuery( '#click-menu #RMX' ).css( 'display', 'block' ); ";        
        else :
        
            $closeX = "";
            $showX = "";
        
        endif;
            
        $js = '';
        
        if( $args != 'strip_tags' ) : 

            $js .= "<script> ";
        
        endif;
        
        $js .= "

            var \$RMjQuery = jQuery.noConflict();

            \$RMjQuery( document ).ready( function( ) {
            
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
                      \$RMjQuery( '#responsive-menu' ).stop().animate( { $side: \"0\" }, $speed, 'linear', function() { 
                          
                        $setHeight
    
                        isOpen = true;

                      } ); 
                      
                }
   
                function closeRM() {

                        $slideBack
                        
                        \$RMjQuery( '#responsive-menu' ).animate( { $side: \"-{$width}%\" }, $speed, 'linear', function() { 
                      
                            $slideRemove
                            $sideSlideRemove
                            $slideOverCssRemove
                            $closeX
                            \$RMjQuery( '#responsive-menu' ).css( 'display', 'none' );  

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

        $js .= " 
            
                clickLink = '<span class=\"appendLink\">&#9660;</span>';
                \$RMjQuery( '#responsive-menu .responsive-menu .sub-menu' ).css( 'display', 'none' ); 
                \$RMjQuery( '#responsive-menu .responsive-menu .menu-item-has-children' ).prepend( clickLink );
                
                \$RMjQuery( '.appendLink' ).on( 'click', function() { 
                
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
    
        $js .= "}); ";

        if( $args != 'strip_tags' ) : 

            $js .= "</script> ";
        
        endif;

        return $js;
            
    }
    

}