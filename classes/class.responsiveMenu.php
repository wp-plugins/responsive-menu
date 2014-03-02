<?php

/*
    Main Class for Responsive Menu
 
    Copyright 2014  Peter Featherstone <peter.featherstone@networkintellect.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

namespace PeterFeatherstone\ResponsiveMenu;

class ResponsiveMenu {
    
    static function install() {
        
        add_option( 'responsive_menu_options', 
                                  
                serialize( array( 
                    
                    'reponsiveMenuMenu' => '',
                    'responsiveMenuBreakpoint' => 400,
                    'reponsiveMenuDepth' => 2,
                    'responsiveMenuTop' => 10 ,
                    'responsiveMenuRight' => 5,
                    'responsiveMenuCss' =>  '',
                    'responsiveMenuTitle' => 'Menu Title',
                    'responsiveMenuLineColour' => '#FFFFFF',
                    'responsiveMenuBackgroundColour' => '#000000',
                    'responsiveMenuButtonTitle' => '',
                    'responsiveMenuBackgroundTransparent' => 'checked',
                    'responsiveMenuFont' => '',
                    'responsiveMenuFixed' => '',
                    'responsiveMenuImage' => 'responsiveMenuImage'
                    
            ) ) );    
        
    }
    
    static function menus() {
        
        add_menu_page( 'Responsive Menu', 
                'Responsive Menu', 
                'manage_options', 
                'responsive-menu', 
                array( '\PeterFeatherstone\ResponsiveMenu\ResponsiveMenu', 'adminPage' ), 
                RM_IMAGES . 'icon.png' 
                );
            
    }
    
    public static function adminPage() {

        if( isset( $_POST['responsiveMenuSubmit'] ) ) :
            
           $validated = self::validate();
        
        endif;
        
        $options = unserialize( get_option( 'responsive_menu_options' ) );

        ?>

<style>
    
    .responsiveMenuDescription
    {
        font-size: 11px;
        margin-bottom: 10px;
    }
    
    .responsiveMenuTitle
    {
        font-weight: bold;
        margin-top: 10px;
    }
    
    .numberInput
    {
        width: 50px;
    }
    
</style>

<script>

    jQuery( document ).ready( function( $ ) { 

        $( '.colourPicker' ).wpColorPicker( );
        
        var custom_uploader;
 
    $('#responsiveMenuImageButton').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#responsiveMenuImage').val(attachment.url);
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });

    });
    
</script>
    
    <div class="wrap">
            
        <form action="" method="post">
            
            <h2>Responsive Menu Options</h2>

            <?php if( isset( $validated ) ) : ?>
        
                <div id="message" class="updated below-h2 cookieBannerSuccess"><p>Your Responsive Menu Options have been updated.</p></div>
            
            <?php endif; ?>
            
            <hr />
            
            <h3>Initial Checks</h3>

            <div class="responsiveMenuTitle">Viewport Meta Tag Check</div> 

            <?php 
                if( self::checkViewPortTag() ) :
                    echo "<span style='color: green;'>Viewport Meta Tag Found - " . self::checkViewPortTag() . "</span>";
                else :
                    echo "<span style='color: red;'>Viewport Meta Tag Not Found</span>";
                endif;

                ?>

            <br /><br />
            
            <hr />
            
            <h3>Menu Settings</h3>
            
            <div class="responsiveMenuTitle">Menu Title</div> 
            
            <div class="responsiveMenuDescription">This is the title at the top of the responsive menu</div>
            
            <input type="text" name="responsiveMenuTitle" value="<?php echo $options['responsiveMenuTitle']; ?>" />

            <div class="responsiveMenuTitle">Menu Image</div> 
            
            <div class="responsiveMenuDescription">This is the image that sits next to the responsive menu title and needs to be 32px x 32 px</div>
            
            <input type="text" id="responsiveMenuImage" name="responsiveMenuImage" value="<?php echo $options['responsiveMenuImage']; ?>" />
            <input type="button" id="responsiveMenuImageButton" value="Upload Image" class="button" />
            
            <div class="responsiveMenuTitle">Menu Button Title</div> 
            
            <div class="responsiveMenuDescription">This is the title under the 3 lines of the menu button</div>
            
            <input type="text" name="responsiveMenuButtonTitle" value="<?php echo $options['responsiveMenuButtonTitle']; ?>" />
            
            <div class="responsiveMenuTitle">Choose Menu To Responsify</div> 

            <div class="responsiveMenuDescription">This is the menu that will be used responsively.</div>

            <?php if( count( get_terms( 'nav_menu' ) ) > 0 ) : ?>
            
                <select name="reponsiveMenuMenu">

                    <?php 

                    foreach( get_terms( 'nav_menu' ) as $menu ) : ?>

                        <option value="<?php echo $menu->slug; ?>"<?php echo $menu->slug == $options['reponsiveMenuMenu'] ? 'selected="selected">' : '>'; ?>
                            <?php echo $menu->name; ?>
                        </option>

                    <?php endforeach;  ?>

                </select>
            
            <?php else : ?>

                <span style="color: red;">You haven't set up any site menus yet.</span>
            
            <?php endif; ?>
            
            <div class="responsiveMenuTitle">Menu Breakpoint</div> 
            
            <div class="responsiveMenuDescription">This is the point where the responsive menu will be visible in px width of the browser</div>
            
            <input class="numberInput" type="text" name="responsiveMenuBreakpoint" value="<?php echo $options['responsiveMenuBreakpoint']; ?>" />px
            
            <div class="responsiveMenuTitle">CSS of Menu To Hide</div> 
            
            <div class="responsiveMenuDescription">This is the CSS of the menu you want to hide once the responsive menu shows - e.g #primary-nav, .menu</div>
            
            <input type="text" name="responsiveMenuCss" value="<?php echo $options['responsiveMenuCss']; ?>" />
            
            <div class="responsiveMenuTitle">Menu Depth</div> 
            
            <div class="responsiveMenuDescription">This is how deep into your menu tree will be visible (max 3)</div>
            
            <select name="reponsiveMenuDepth">

                <?php for( $i=1; $i<4; $i++ ) : ?>

                    <option value="<?php echo $i; ?>"<?php echo $i == $options['reponsiveMenuDepth'] ? 'selected="selected">' : '>'; ?>
                        <?php echo $i; ?>
                    </option>

                <?php endfor; ?>

            </select>
            
            <hr />
            
            <h3>Location Settings</h3>
            
            <div class="responsiveMenuTitle">Top</div> 
            
            <div class="responsiveMenuDescription">This is the distance from the top of the page in px that the menu will be displayed</div>
            
            <input class="numberInput" type="text" name="responsiveMenuTop" value="<?php echo $options['responsiveMenuTop']; ?>" />px

            <div class="responsiveMenuTitle">Right</div> 
            
            <div class="responsiveMenuDescription">This is the distance from the right of the page in percentage that the menu will be displayed</div>
            
            <input class="numberInput" type="text" name="responsiveMenuRight" value="<?php echo $options['responsiveMenuRight']; ?>" />%
  
            <hr />
            
            <h3>Style Settings</h3>
            
            <div class="responsiveMenuTitle">Menu Line & Text Colour</div> 
            
            <div class="responsiveMenuDescription">This is the colour of the 3 lines and text for the menu button</div>
            
            <input 
                type="text" 
                name="responsiveMenuLineColour" 
                id="responsiveMenuLineColour" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['responsiveMenuLineColour'] ); ?>" 
            />
            
            <div class="responsiveMenuTitle">Menu Background Colour</div> 
            
            <div class="responsiveMenuDescription">This is the background colour of the 3 lines container</div>
            
            <input 
                type="text" 
                name="responsiveMenuBackgroundColour" 
                id="responsiveMenuBackgroundColour" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['responsiveMenuBackgroundColour'] ); ?>" 
            />

            <div class="responsiveMenuTitle">Menu Background Transparent</div> 
            
            <div class="responsiveMenuDescription">Tick this if you would like a transparent background</div>
            
            <input 
                type="checkbox" 
                name="responsiveMenuBackgroundTransparent" 
                id="responsiveMenuBackgroundTransparent"
                value="checked"
                <?php echo $options['responsiveMenuBackgroundTransparent'] == 'checked' ? ' checked="checked" ' : ''; ?>
            />
            
            <div class="responsiveMenuTitle">Fixed Positioning</div> 
            
            <div class="responsiveMenuDescription">Tick this if you would like the menu button to remain in the same place when scrolling.</div>
            
            <input 
                type="checkbox" 
                name="responsiveMenuFixed" 
                id="responsiveMenuFixed"
                value="fixed"
                <?php echo $options['responsiveMenuFixed'] == 'fixed' ? ' checked="checked" ' : ''; ?>
            />
            
            <div class="responsiveMenuTitle">Font</div> 
            
            <div class="responsiveMenuDescription">Enter your preferred font name below, if empty your default site font will be used.</div>
            
            <input type="text" name="responsiveMenuFont" value="<?php echo $options['responsiveMenuFont']; ?>" />
            
            <br /><br />
            
            <input type="submit" class="button button-primary" name="responsiveMenuSubmit" value="Update Responsive Menu Options" />
            
        </form>
        
    </div>

<?php        
         
    }
    
    private static function validate() {
        
        if( isset( $_POST['responsiveMenuSubmit'] ) ) :
            
           update_option( 'responsive_menu_options', 
                   
                serialize( array( 
                    
                    'reponsiveMenuMenu' => stripslashes( strip_tags( trim( $_POST['reponsiveMenuMenu'] ) ) ),
                    'responsiveMenuBreakpoint' => intval( $_POST['responsiveMenuBreakpoint'] ),
                    'reponsiveMenuDepth' => intval( $_POST['reponsiveMenuDepth'] ),
                    'responsiveMenuTop' => intval( $_POST['responsiveMenuTop'] ),
                    'responsiveMenuRight' => intval( $_POST['responsiveMenuRight'] ),
                    'responsiveMenuCss' => stripslashes( strip_tags( trim( $_POST['responsiveMenuCss'] ) ) ),
                    'responsiveMenuTitle' => stripslashes( strip_tags( trim( $_POST['responsiveMenuTitle'] ) ) ),
                    'responsiveMenuLineColour' => stripslashes( strip_tags( trim( $_POST['responsiveMenuLineColour'] ) ) ),
                    'responsiveMenuBackgroundColour' => stripslashes( strip_tags( trim( $_POST['responsiveMenuBackgroundColour'] ) ) ),
                    'responsiveMenuButtonTitle' => stripslashes( strip_tags( trim( $_POST['responsiveMenuButtonTitle'] ) ) ),
                    'responsiveMenuBackgroundTransparent' => stripslashes( strip_tags( trim( $_POST['responsiveMenuBackgroundTransparent'] ) ) ),
                    'responsiveMenuFont' => stripslashes( strip_tags( trim( $_POST['responsiveMenuFont'] ) ) ),
                    'responsiveMenuFixed' => stripslashes( strip_tags( trim( $_POST['responsiveMenuFixed'] ) ) ),
                    'responsiveMenuImage' => stripslashes( strip_tags( trim( $_POST['responsiveMenuImage'] ) ) )
            ) ) );    
   
            return true;
            
        else :
            
            return false;
            
        endif;
        
    }
    
    static function displayMenu() { 
        
        echo self::getJavascript();
        echo self::getCSS();
        echo self::getHTML();
       
    }
    
    static function getJavascript() {

        $options = unserialize( get_option( 'responsive_menu_options' ) );
        
        $js = "
        
        <script>

            jQuery( document ).ready( function( $ ) {

                // Toggle Responsive Menu Once Button Clicked
                
                isOpen = false;
                
                getHeightOfIOSToolbars = function() {
            
                    var tH = ( window.orientation === 0 ? screen.height : screen.width) -  getIOSWindowHeight();
                    return tH > 1 ? tH : 0;

                };

            $( '#click-menu' ).click( function() { 

                height = "; $js .= $options['responsiveMenuFixed'] == 'fixed' ? "$( window ).innerHeight();" : "$( document ).height();";
                        
             $js .= "if( !isOpen ) {
                
                      $( '#responsive-menu' ).css( 'display', 'block' );
                      $( '#responsive-menu' ).css( 'height', height + getHeightOfIOSToolbars ); 
                      $( '#responsive-menu' ).stop().animate( { left: \"0\" }, 500 ); 
                      isOpen = true;

                } else {
                
                      $( '#responsive-menu' ).stop().animate( { left: \"20\" }, 500 );
                      $( '#responsive-menu' ).animate( { left: \"-5000\" }, 4000 );
                      $( '#responsive-menu' ).stop().css( 'display', 'none' );
                      isOpen = false;
                      
                }

                // Close Responive Menu If Browser Width Goes Above {$options['responsiveMenuBreakpoint']}px
                $( document ).resize(function() { ";
                
               $js .= $options['responsiveMenuFixed'] == 'fixed' ? "$( '#responsive-menu' ).css( 'height', $( window ).innerHeight() + getHeightOfIOSToolbars ); " : "";

               $js .= "if( $( document ).width() > {$options['responsiveMenuBreakpoint']} ) { 

                        if( $( '#responsive-menu' ).css( 'left' ) != '-5000px' ) {

                            $( '#responsive-menu' ).animate( { left: \"-5000\" }, 700 );  
                            $( '#responsive-menu' ).css( 'display', 'none' ); 

                        }

                    }

});

                });

            });
        
        </script>";
        
        echo $js;

    }
    
    static function getHTML() {
      
        $options = unserialize( get_option( 'responsive_menu_options' ) );
        
        $html = '
            <div id="responsive-menu">
			
                <div id="responsive-menu-title">';
        
        $html .= $options['responsiveMenuImage'] ? '<div class="responsiveMenuImageContainer"><img src="' . $options['responsiveMenuImage'] . '" class="responsiveMenuImage" /></div>' : '';

        $html .= $options['responsiveMenuTitle'] . '</div>';
						
        $html .= wp_nav_menu( array( 
            'menu' => $options['reponsiveMenuMenu'], 
            'echo' => false, 
            'menu_class' => 'responsive-menu' ) );
		
        $html .= '<form action="/" id="responsiveSearch" method="get" role="search">

                    <input type="text" name="s" value="" placeholder="Search" id="responsiveSearchInput">

                </form>
            
            </div>';
        
        $html .= '<div id="click-menu"> 
                            
                    <div class="threeLines">
                            
                    <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>';
               
       
        
        if( $options['responsiveMenuButtonTitle'] ) $html .= '<div id="click-menu-label">' . $options['responsiveMenuButtonTitle'] . '</div>';

                   $html .= '</div>';
        
        return $html;
        
    }
    
    static function getCSS() {

        $options = unserialize( get_option( 'responsive_menu_options' ) );
        
        $css = "

        <style>

            #responsive-menu .responsiveMenuImageContainer
            {
                height: 32px;
                width: 32px;
                overflow: hidden;
                margin-right: 15px;
            }

            #responsive-menu .responsiveMenuImage
            {
                width: 100%;
                vertical-align: sub;
            }

            #responsive-menu								
            { ";
        
        $css .= $options['responsiveMenuFixed'] == 'fixed' ? "position: fixed; overflow-y: scroll;" : "position: absolute;";
        
        $css .= " 
                width: 75%; 
                top: 0px; 
                bottom: 0px;
                left: -5000px; 
                background: #43494C;												  
                z-index: 9999;  
                box-shadow: 0px 1px 8px #333333; 
                font-size: 13px;												  
                color: white; 
                display: none;";
        
        $css .= !empty( $options['responsiveMenuFont'] ) ? 'font-family: "' . $options['responsiveMenuFont'] . '";' : '';
                
        $css .="
            }";
        
        $css .= !empty( $options['responsiveMenuFont'] ) ? ' #responsive-menu input { font-family: "' . $options['responsiveMenuFont'] . '"; } ' : '';

        $css .= "
            #responsive-menu  #responsive-menu-title			
            { 
                color: white; 
                width: 95%; 
                font-size: 14px; 
                padding: 20px 0px 20px 5%;
                margin-left: 0px;
                line-height: 32px;
            }


            #responsive-menu .responsive-menu			
            { 
                float: left;  
                width: 100%; 
                list-style-type: none;
                margin: 0px;
            }
                        
            #responsive-menu  .responsive-menu ul
            {
                margin-left: 0px !important;
            }

            #responsive-menu .responsive-menu li		
            { 
                border-top: 1px solid #3C3C3C !important; 
                list-style-type: none !important;
            }

            #responsive-menu .responsive-menu li:hover	
            { 
                background: #3C3C3C !important; 
            }

            #responsive-menu .responsive-menu li a:hover
            {
                text-decoration: none !important;
            }
            
            #responsive-menu .responsive-menu ul li:last-child	
            { 
                padding-bottom: 0px !important; 
            }

            #responsive-menu .responsive-menu li a	
            { 
                padding-left: 5% !important; 
                width: 95% !important; 
                display: block !important; 
                color: white !important;
                text-decoration: none !important;
            }

            #click-menu						
            { 
                text-align: center;
                cursor: pointer; 
                width: 50px;
                display: none;";
                
                $css .= $options['responsiveMenuFixed'] == 'fixed' ? "position: fixed;" : "position: absolute;";
                
                $css .= "right: {$options['responsiveMenuRight']}%;
                top: {$options['responsiveMenuTop']}px;
                color: {$options['responsiveMenuLineColour']};";
                
                if( !$options['responsiveMenuBackgroundTransparent'] ) 
                    $css .= "background: {$options['responsiveMenuBackgroundColour']};";
                
                $css .= "
                padding: 5px;
                border-radius: 5px;
                z-index: 9999;
            }

            #responsive-menu #responsiveSearch
            {
                display: block;
                width: 95%;
                padding-left: 5%;
                border-top: 1px solid #3C3C3C;
                clear: both;
                padding-top: 10px;
                height: 40px;
                line-height: 40px;
            }

            #responsive-menu #responsiveSearchInput
            {
                width: 93%;
                padding: 5px 0px 5px 1%;
                -webkit-appearance: none;
            }
  
            #responsive-menu .responsive-menu,
            #responsive-menu div,
            #responsive-menu .responsive-menu li
            {
                width: 100%;
                float: left !important;
                margin-left: 0px !important;
            }

            #responsive-menu .responsive-menu li a
            {
                padding: 12px 0px 12px 5% !important;
                width: 95% !important;
                display: block !important;
                overflow: hidden !important;
                white-space: nowrap !important;
            }

            #responsive-menu .responsive-menu li li a
            {
                padding-left: 10% !important;
                width: 90% !important;
                height: 20px !important;
                overflow: hidden !important;
            }
 
            #responsive-menu .responsive-menu li li li a
            {
                padding-left: 15% !important;
                width: 85% !important;
                height: 20px !important;
                overflow: hidden !important;
            }
            
            #responsive-menu .responsive-menu li li li li
            {
                display: none;
            }
            
            #responsive-menu .responsive-menu li a:hover
            {
                background: #3C3C3C;
            }";
                
                if( $options['reponsiveMenuDepth'] == 1) $css .= " #responsive-menu .responsive-menu li li { display: none; } ";
                if( $options['reponsiveMenuDepth'] == 2) $css .= " #responsive-menu .responsive-menu li li li { display: none; } ";
                
                $css .= "
            
            #click-menu .threeLines
            {
                width: 43px;
                height: 33px;
                margin: auto;
            }

            #click-menu .threeLines .line
            {
                height: 5px;
                margin-bottom: 6px;
                background: {$options['responsiveMenuLineColour']};
                width: 100%;
            }

            @media only screen and ( min-width : 0px ) and ( max-width : {$options['responsiveMenuBreakpoint']}px ) { 

                #click-menu	
                {
                    display: block;
                }

";

if( $options['responsiveMenuCss'] ) $css .= "{$options['responsiveMenuCss']} { display: none !important; } ";

$css .= "   }

        </style>";

        return $css;

    }
    
    private static function checkViewPortTag() {

        $metaTags = get_meta_tags( get_bloginfo( 'url' ) );
        
        if( $metaTags['viewport'] ) return $metaTags['viewport'];
                          
    }
    
}