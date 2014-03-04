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

class ResponsiveMenu {
    
    static function install() {
        
        if( get_option( 'responsive_menu_options' ) ) :

            // Migrate Old Data 
            $options = unserialize( get_option( 'responsive_menu_options' ) );
        
            add_option( 'RMOptions', 
                                  
                serialize( array( 
                    
                    'RM' => $options['reponsiveMenuMenu'],
                    'RMBreak' => $options['responsiveMenuBreakpoint'],
                    'RMDepth' => $options['reponsiveMenuDepth'],
                    'RMTop' => $options['responsiveMenuTop'] ,
                    'RMRight' => $options['responsiveMenuRight'],
                    'RMCss' =>  $options['responsiveMenuCss'],
                    'RMTitle' => $options['responsiveMenuTitle'],
                    'RMLineCol' => $options['responsiveMenuLineColour'],
                    'RMClickBkg' => $options['responsiveMenuBackgroundColour'],
                    'RMClickTitle' => $options['responsiveMenuButtonTitle'],
                    'RMBkgTran' => $options['responsiveMenuBackgroundTransparent'],
                    'RMFont' => $options['responsiveMenuFont'],
                    'RMPos' => $options['responsiveMenuFixed'],
                    'RMImage' => $options['responsiveMenuImage'],
                    'RMWidth' => $options['responsiveMenuWidth'],
                    'RMBkg' => $options['responsiveMenuMainBackground'],
                    'RMBkgHov' => $options['responsiveMenuMainBackgroundHover'] ,
                    'RMTitleCol' => $options['responsiveMenuMainTitleColour'],
                    'RMTextCol' => $options['responsiveMenuMainTextColour'],
                    'RMBorCol' => $options['responsiveMenuMainBorderColour'],
                    'RMTextColHov' => $options['responsiveMenuMainTextColourHover'],
                    'RMTitleColHov' => $options['responsiveMenuMainTitleColourHover'],
                    'RMAnim' => 'overlay'
                  
            ) ) );    
        
       else :
        
        add_option( 'RMOptions', 
                                  
                serialize( array( 
                    
                    'RM' => '',
                    'RMBreak' => 400,
                    'RMDepth' => 2,
                    'RMTop' => 10 ,
                    'RMRight' => 5,
                    'RMCss' =>  '',
                    'RMTitle' => 'Menu Title',
                    'RMLineCol' => '#FFFFFF',
                    'RMClickBkg' => '#000000',
                    'RMClickTitle' => '',
                    'RMBkgTran' => 'checked',
                    'RMFont' => '',
                    'RMPos' => '',
                    'RMImage' => '',
                    'RMWidth' => '75',
                    'RMBkg' => '#43494C',
                    'RMBkgHov' => '#3C3C3C' ,
                    'RMTitleCol' => '#FFFFFF',
                    'RMTextCol' => '#FFFFFF',
                    'RMBorCol' => '#3C3C3C',
                    'RMTextColHov' => '#FFFFFF',
                    'RMTitleColHov' => '#FFFFFF',
                    'RMAnim' => 'overlay'
                  
            ) ) );    
        
        endif;
        
    }
    
    static function menus() {
        
        add_menu_page( 'Responsive Menu', 
                'Responsive Menu', 
                'manage_options', 
                'responsive-menu', 
                array( 'ResponsiveMenu', 'adminPage' ), 
                RM_IMAGES . 'icon.png' 
                );
            
    }
    
    public static function adminPage() {

        if( isset( $_POST['RMSubmit'] ) ) :
            
           $validated = self::validate();
        
        endif;
        
        $options = unserialize( get_option( 'RMOptions' ) );

        ?>

<style>
 
    h4
    {
        font-weight: bold;
        margin: 10px 0px 0px 0px;
    }
    
    h5
    {
        font-size: 11px;
        margin: 0px 0px 10px 0px;
    }
    
    .numberInput
    {
        width: 50px;
    }
    
    table
    {
        width: 100%;
    }
    
    table td
    {
        width: 48%;
        padding-right: 2%;
    }
    
</style>

<script>

    jQuery( document ).ready( function( $ ) { 

        $( '.colourPicker' ).wpColorPicker( );
        
        var custom_uploader;
 
    $('#RMImageButton').click(function(e) {
 
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
            $('#RMImage').val(attachment.url);
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

            <h4>Viewport Meta Tag Check</h4> 

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
            
            <table>
                <tr>
                    <td>
                        
            <h4>Menu Title</h4> 
            
            <h5>This is the title at the top of the responsive menu</h5>
            
            <input type="text" name="RMTitle" value="<?php echo $options['RMTitle']; ?>" />

                    </td>
                    <td>
                        
            <h4>Menu Image</h4> 
            
            <h5>This is the image that sits next to the responsive menu title and needs to be 32px x 32 px</h5>
            
            <input type="text" id="RMImage" name="RMImage" value="<?php echo $options['RMImage']; ?>" />
            <input type="button" id="RMImageButton" value="Upload Image" class="button" />
            
                    </td>
                <tr>
                    <td>
            <h4>Menu Button Title</h4> 
            
            <h5>This is the title under the 3 lines of the menu button</h5>
            
            <input type="text" name="RMClickTitle" value="<?php echo $options['RMClickTitle']; ?>" />
                    </td>
                    <td>
            <h4>Choose Menu To Responsify</h4> 

            <h5>This is the menu that will be used responsively.</h5>

            <?php if( count( get_terms( 'nav_menu' ) ) > 0 ) : ?>
            
                <select name="RM">

                    <?php 

                    foreach( get_terms( 'nav_menu' ) as $menu ) : ?>

                        <option value="<?php echo $menu->slug; ?>"<?php echo $menu->slug == $options['RM'] ? 'selected="selected">' : '>'; ?>
                            <?php echo $menu->name; ?>
                        </option>

                    <?php endforeach;  ?>

                </select>
            
            <?php else : ?>

                <span style="color: red;">You haven't set up any site menus yet.</span>
            
            <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>
            <h4>Menu Breakpoint</h4> 
            
            <h5>This is the point where the responsive menu will be visible in px width of the browser</h5>
            
            <input class="numberInput" type="text" name="RMBreak" value="<?php echo $options['RMBreak']; ?>" />px
            
                    </td>
                    <td>
            <h4>CSS of Menu To Hide</h4> 
            
            <h5>This is the CSS of the menu you want to hide once the responsive menu shows - e.g #primary-nav, .menu</h5>
            
            <input type="text" name="RMCss" value="<?php echo $options['RMCss']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
            <h4>Menu Depth</h4> 
            
            <h5>This is how deep into your menu tree will be visible (max 3)</h5>
            
            <select name="RMDepth">

                <?php for( $i=1; $i<4; $i++ ) : ?>

                    <option value="<?php echo $i; ?>"<?php echo $i == $options['RMDepth'] ? 'selected="selected">' : '>'; ?>
                        <?php echo $i; ?>
                    </option>

                <?php endfor; ?>

            </select>
                    </td>
                    <td>
                        <h4>Menu Width</h4> 
            
            <h5>This is the width the menu takes up across the page once expanded.</h5>
            
            <input class="numberInput" type="text" name="RMWidth" value="<?php echo isset( $options['RMWidth'] ) ? $options['RMWidth'] : ''; ?>" />%
            
                    </td></tr></table>
            <hr />
            
            <h3>Location Settings</h3>
            
            <table>
                <tr>
                    <td>
            <h4>Top</h4> 
            
            <h5>This is the distance from the top of the page in px that the menu will be displayed</h5>
            
            <input class="numberInput" type="text" name="RMTop" value="<?php echo $options['RMTop']; ?>" />px
                    </td>
                    <td>
                        
            <h4>Right</h4> 
            
            <h5>This is the distance from the right of the page in percentage that the menu will be displayed</h5>
            
            <input class="numberInput" type="text" name="RMRight" value="<?php echo $options['RMRight']; ?>" />%
  
                    </td>
                </tr></table>
            <hr />
            
            <h3>Style Settings</h3>
            
            <table>
                <tr>
                    <td>
                
            <h4>Menu Line & Text Colour</h4> 
            
            <h5>This is the colour of the 3 lines and text for the menu button</h5>
            
            <input 
                type="text" 
                name="RMLineCol" 
                id="RMLineCol" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['RMLineCol'] ); ?>" 
            />
                    </td>
                    <td>
            <h4>Menu Button Background Colour</h4> 
            
            <h5>This is the background colour of the 3 lines container</h5>
            
            <input 
                type="text" 
                name="RMClickBkg" 
                id="RMClickBkg" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['RMClickBkg'] ); ?>" 
            />
                    </td>
            </tr>
                <tr>
                    <td>
                
            <h4>Menu Background Colour</h4> 
            
            <h5>This is the background colour of the expanded menu</h5>
            
            <input 
                type="text" 
                name="RMBkg" 
                id="RMBkg" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['RMBkg'] ); ?>" 
            />
                    </td>
                    <td>
            <h4>Menu Background Hover Colour</h4> 
            
            <h5>This is the hover background colour of the expanded menu</h5>
            
            <input 
                type="text" 
                name="RMBkgHov" 
                id="RMBkgHov" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['RMBkgHov'] ); ?>" 
            />
                    </td>
            </tr>
                            <tr>

                                        <td>
                
            <h4>Menu Title Colour</h4> 
            
            <h5>This is the text colour of the expanded menu title</h5>
            
            <input 
                type="text" 
                name="RMTitleCol" 
                id="RMTitleCol" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['RMTitleCol'] ); ?>" 
            />
                    </td>
                    
                                        <td>
                
            <h4>Menu Title Hover Colour</h4> 
            
            <h5>This is the hover colour of the expanded menu title</h5>
            
            <input 
                type="text" 
                name="RMTitleColHov" 
                id="RMTitleColHov" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['RMTitleColHov'] ); ?>" 
            />
                    </td>
                            </tr>
                            <tr>
                    <td>
            <h4>Menu Text Colour</h4> 
            
            <h5>This is the text colour of the expanded menu links</h5>
            
            <input 
                type="text" 
                name="RMTextCol" 
                id="RMTextCol" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['RMTextCol'] ); ?>" 
            />
                    </td>
                                        <td>
            <h4>Menu Text Hover Colour</h4> 
            
            <h5>This is the text hover colour of the expanded menu links</h5>
            
            <input 
                type="text" 
                name="RMTextColHov" 
                id="RMTextColHov" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['RMTextColHov'] ); ?>" 
            />
                    </td>
            </tr>
                                        <tr>
                    <td>
                
            <h4>Menu Link Border Colour</h4> 
            
            <h5>This is the border colour of the expanded menu titles</h5>
            
            <input 
                type="text" 
                name="RMBorCol" 
                id="RMBorCol" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['RMBorCol'] ); ?>" 
            />
                    </td>
                    <td>
            
                    </td>
            </tr>
                <tr>
                    <td>
            <h4>Menu Background Transparent</h4> 
            
            <h5>Tick this if you would like a transparent background</h5>
            
            <input 
                type="checkbox" 
                name="RMBkgTran" 
                id="RMBkgTran"
                value="checked"
                <?php echo $options['RMBkgTran'] == 'checked' ? ' checked="checked" ' : ''; ?>
            />
                    </td><td>
            <h4>Fixed Positioning</h4> 
            
            <h5>Tick this if you would like the menu button to remain in the same place when scrolling.</h5>
            
            <input 
                type="checkbox" 
                name="RMPos" 
                id="RMPos"
                value="fixed"
                <?php echo $options['RMPos'] == 'fixed' ? ' checked="checked" ' : ''; ?>
            />
            </td>
            </tr>
            <tr>
                <td>
                                <h4>Font</h4> 
            
            <h5>Enter a font name below, if empty your default site font will be used.</h5>
            
            <input type="text" name="RMFont" value="<?php echo isset( $options['RMFont'] ) ? $options['RMFont'] : ''; ?>" />
            
                </td>
                <td></td>
            </tr>
            </table>
            
            <hr />
            
            <h3>Animation Settings</h3>
            
            <h4>Slide Animation</h4> 
            
            <h5>Choose the type of animation applied to the menu</h5>
            
            <select name="RMAnim">

                <option value="overlay"<?php echo 'overlay' == $options['RMAnim'] ? ' selected="selected " ' : ''; ?>>Overlay</option>
                <option value="push"<?php echo 'push' == $options['RMAnim'] ? ' selected="selected " ' : ''; ?>>Push</option>      

            </select>
            
            <br /><br />
            
            <input type="submit" class="button button-primary" name="RMSubmit" value="Update Responsive Menu Options" />
            
        </form>
        
    </div>

<?php        
         
    }
    
    private static function validate() {
        
        if( isset( $_POST['RMSubmit'] ) ) :
            
            // Initialise Variables Correctly
            $RM = isset( $_POST['RM'] ) ? $_POST['RM'] : ''; 
            $RMTitle = isset( $_POST['RMTitle'] ) ? $_POST['RMTitle'] : ''; 
            $RMBreak = isset( $_POST['RMBreak'] ) ? $_POST['RMBreak'] : ''; 
            $RMDepth = isset( $_POST['RMDepth'] ) ? $_POST['RMDepth'] : '1'; 
            $RMTop = isset( $_POST['RMTop'] ) ? $_POST['RMTop'] : ''; 
            $RMRight = isset( $_POST['RMRight'] ) ? $_POST['RMRight'] : ''; 
            $RMCss = isset( $_POST['RMCss'] ) ? $_POST['RMCss'] : ''; 
            $RMLineCol = isset( $_POST['RMLineCol'] ) ? $_POST['RMLineCol'] : ''; 
            $RMClickBkg = isset( $_POST['RMClickBkg'] ) ? $_POST['RMClickBkg'] : ''; 
            $RMClickTitle = isset( $_POST['RMClickTitle'] ) ? $_POST['RMClickTitle'] : ''; 
            $RMBkgTran = isset( $_POST['RMBkgTran'] ) ? $_POST['RMBkgTran'] : ''; 
            $RMPos = isset( $_POST['RMPos'] ) ? $_POST['RMPos'] : ''; 
            $RMImage = isset( $_POST['RMImage'] ) ? $_POST['RMImage'] : ''; 
            $RMWidth = isset( $_POST['RMWidth'] ) ? $_POST['RMWidth'] : '75';
            $RMBkg = isset( $_POST['RMBkg'] ) ? $_POST['RMBkg'] : '#43494C';
            $RMBkgHov = isset( $_POST['RMBkgHov'] ) ? $_POST['RMBkgHov'] : '#3C3C3C';
            $RMTitleCol = isset( $_POST['RMTitleCol'] ) ? $_POST['RMTitleCol'] : '#FFFFFF';
            $RMTextCol = isset( $_POST['RMTextCol'] ) ? $_POST['RMTextCol'] : '#FFFFFF';
            $RMBorCol = isset( $_POST['RMBorCol'] ) ? $_POST['RMBorCol'] : '#3C3C3C';                
            $RMTextColHov = isset( $_POST['RMTextColHov'] ) ? $_POST['RMTextColHov'] : '#FFFFFF'; 
            $RMTitleColHov = isset( $_POST['RMTitleColHov'] ) ? $_POST['RMTitleColHov'] : '#FFFFFF'; 
            $RMAnim = isset( $_POST['RMAnim'] ) ? $_POST['RMAnim'] : 'overlay'; 
            
           // Update Submitted Options 
           update_option( 'RMOptions', 
                   
                // Serialize For Database
                serialize( array( 
                    
                    // Filter Input Correctly
                    'RM' => self::filterInput( $RM ),
                    'RMBreak' => intval( $RMBreak ),
                    'RMDepth' => intval( $RMDepth ),
                    'RMTop' => intval( $RMTop ),
                    'RMRight' => intval( $RMRight ),
                    'RMCss' => self::filterInput( $RMCss ),
                    'RMTitle' => self::filterInput( $RMTitle ),
                    'RMLineCol' => self::filterInput($RMLineCol ),
                    'RMClickBkg' => self::filterInput( $RMClickBkg ),
                    'RMClickTitle' => self::filterInput( $RMClickTitle ),
                    'RMBkgTran' => self::filterInput( $RMBkgTran ),
                    'RMFont' => self::filterInput( $RMFont ),
                    'RMPos' => self::filterInput( $RMPos ),
                    'RMImage' => self::filterInput( $RMImage ),
                    'RMWidth' => intval( $RMWidth ),
                    'RMBkg' => self::filterInput( $RMBkg ),
                    'RMBkgHov' => self::filterInput( $RMBkgHov ),
                    'RMTitleCol' => self::filterInput( $RMTitleCol ),
                    'RMTextCol' => self::filterInput( $RMTextCol ),
                    'RMBorCol' => self::filterInput( $RMBorCol ),
                    'RMTextColHov' => self::filterInput( $RMTextColHov ),
                    'RMTitleColHov' => self::filterInput( $RMTitleColHov ),
                    'RMAnim' => self::filterInput( $RMAnim ),
     
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

        $options = unserialize( get_option( 'RMOptions' ) );
        
        $setHeight = $options['RMPos'] == 'fixed' ? '' : " $( '#responsive-menu' ).css( 'height', $( document ).height() ); ";
        $breakpoint = empty( $options['RMBreak'] ) ? "400" : $options['RMBreak'];
        $width = empty( $options['RMWidth'] ) ? "75" : $options['RMWidth'];
        
        $slideOpen = $options['RMAnim'] == 'push' ? " $( 'body' ).addClass( 'RMPushOpen' ); " : '';
        $slideRemove = $options['RMAnim']  == 'push' ? " $( 'body' ).removeClass( 'RMPushOpen' ); " : '';

        $slideOver = $options['RMAnim'] == 'push' ? " $( '#page' ).animate( { left: \"$width%\" }, 500, 'linear' ); " : '';
        $slideOverCss = $options['RMAnim'] == 'push' ? " $( '#page' ).addClass( 'RMPushSlide' ); " : '';

        $slideBack = $options['RMAnim'] == 'push' ? " $( '#page' ).animate( { left: \"0\" }, 500, 'linear' ); " : '';
        $slideOverCssRemove = $options['RMAnim'] == 'push' ? " $( '#page' ).removeClass( 'RMPushSlide' ); " : '';
        
        $js = "
        <script>

            jQuery( document ).ready( function( $ ) {

                // Toggle Responsive Menu Once Button Clicked
                
                isOpen = false;

            $( '#click-menu' ).click( function() {
                        
                $setHeight
                    
                if( !isOpen ) {
                
                      $slideOpen  
                      $slideOverCss
                      $slideOver
                          
                      $( '#responsive-menu' ).css( 'display', 'block' ); 
                      $( '#responsive-menu' ).stop().animate( { left: \"0\" }, 500, 'linear' ); 

                      isOpen = true;

                } else {

                        $slideBack
                        
                        $( '#responsive-menu' ).animate( { left: \"-{$width}%\" }, 500, 'linear', function() { 
                      
                            $slideRemove
                            $slideOverCssRemove
                            $( '#responsive-menu' ).css( 'display', 'none' );  

                        } );
                      
                      isOpen = false;
                      
                }

                // Close Responsive Menu If Browser Width Goes Above {$breakpoint}px
                    
                $( window ).resize(function() { 
                
                    $setHeight

                    if( $( window ).width() > $breakpoint ) { 

                        if( $( '#responsive-menu' ).css( 'left' ) != '-{$width}%' ) {

                        $slideBack
                            
                        $( '#responsive-menu' ).animate( { left: \"-{$width}%\" }, 500, 'linear', function() { 
                        
                            $slideRemove
                            $slideOverCssRemove                      
                            $( '#responsive-menu' ).css( 'display', 'none' );  

                        } );

                        }

                    }

                    });

                });

            });
        
        </script>";
        
        echo $js;

    }
    
    static function getHTML() {
      
        $options = unserialize( get_option( 'RMOptions' ) );
        
        $html = '
            <div id="responsive-menu">
			
                <div id="responsive-menu-title">';
        
        $html .= $options['RMImage'] ? '<div class="RMImageContainer"><a href="' . get_site_url() . ' "><img src="' . $options['RMImage'] . '" class="RMImage" /></a></div>' : '';

        $html .= '<a href="' . get_site_url() . ' ">' . $options['RMTitle'] . '</a></div>';
						
        $html .= wp_nav_menu( array( 
            'menu' => $options['RM'], 
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
               
        $html .= $options['RMClickTitle'] ? '<div id="click-menu-label">' . $options['RMClickTitle'] . '</div>' : '';

        $html .= '</div>';
        
        return $html;
        
    }
    
    static function getCSS() {

        $options = unserialize( get_option( 'RMOptions' ) );
        
        $position = $options['RMPos'] == 'fixed' ? 'fixed' : 'absolute';
        $overflowy = $options['RMPos'] == 'fixed' ? 'overflow-y: auto;' : '';
        $bottom = $options['RMPos'] == 'fixed' ? 'bottom: 0px;' : '';
        
        $right = empty( $options['RMRight'] ) ? '0' : $options['RMRight'];
        $top = empty( $options['RMTop'] ) ? '0' : $options['RMTop'];
        $width = empty( $options['RMWidth'] ) ? '75' : $options['RMWidth'];
        $mainBkg = empty( $options['RMBkg'] ) ? "#43494C" : $options['RMBkg'];
        $mainBkgH = empty( $options['RMBkgHov'] ) ? "#3C3C3C" : $options['RMBkgHov'];
        $font = empty( $options['RMFont'] ) ? '' : 'font-family: "' . $options['RMFont'] . '";';
        $titleCol = empty( $options['RMTitleCol'] ) ? '#FFFFFF' : $options['RMTitleCol'];
        $titleColH = empty( $options['RMTitleColHov'] ) ? '#FFFFFF' : $options['RMTitleColHov'];
        $txtCol = empty( $options['RMTextCol'] ) ? "#FFFFFF" : $options['RMTextCol'];
        $txtColH = empty( $options['RMTextColHov'] ) ? "#FFFFFF" : $options['RMTextColHov'];
        $clickCol = empty( $options['RMLineCol'] ) ? "#FFFFFF" : $options['RMLineCol'];
        $clickBkg = empty( $options['RMBkgTran'] ) ? "background: {$options['RMClickBkg']};" : '';      
        $borCol = empty( $options['RMBorCol'] ) ? "#3C3C3C" : $options['RMBorCol'];
        $breakpoint = empty( $options['RMBreak'] ) ? "400" : $options['RMBreak'];

        $css = "

        <style>

            .RMPushOpen
            {
                width: 100% !important;
                overflow-x: hidden !important;
            }

            .RMPushSlide
            {
                position: relative;
                left: $width%;
            }

#page
{
position: relative;
left: 0px;
}

            #responsive-menu								
            { 
                position: $position;
                $overflowy
                $bottom
                width: $width%;
                top: 0px; 
                left: -$width%;
                background: $mainBkg;
                z-index: 9999;  
                box-shadow: 0px 1px 8px #333333; 
                font-size: 13px;
                max-width: 999px;
                display: none;
            }
            
            #responsive-menu .RMImageContainer
            {
                height: 32px;
                width: 32px;
                overflow: hidden;
                margin-right: 5px;
            }

            #responsive-menu .RMImage
            {
                width: 100%;
                vertical-align: sub;
            }

            #responsive-menu input {
                $font
            }      
            
            #responsive-menu #responsive-menu-title			
            {
                width: 95%; 
                font-size: 14px; 
                padding: 20px 0px 20px 5%;
                margin-left: 0px;
                line-height: 32px;
            }
      
            #responsive-menu #responsive-menu-title,
            #responsive-menu #responsive-menu-title a
            {
                color: $titleCol !important;
            }
            
            #responsive-menu #responsive-menu-title a:hover {
                color: $titleColH !important;
            }
   
            #responsive-menu .responsive-menu li a,
            #responsive-menu #responsive-menu-title a
            {

                transition: 1s all;
                -webkit-transition: 1s all;
                -moz-transition: 1s all;
                -o-transition: 1s all;

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
                list-style-type: none !important;
            }

            #responsive-menu .responsive-menu ul li:last-child	
            { 
                padding-bottom: 0px !important; 
            }

            #responsive-menu .responsive-menu li a	
            { 
                padding: 12px 0px 12px 5% !important;
                width: 95% !important;
                display: block !important;
                height: 20px !important;
                line-height: 20px !important;
                overflow: hidden !important;
                white-space: nowrap !important;
                color: $txtCol !important;
                border-top: 1px solid $borCol !important; 
                text-decoration: none !important;
            }

            #click-menu						
            { 
                text-align: center;
                cursor: pointer; 
                width: 50px;
                font-size: 13px;
                display: none;
                position: $position;
                right: $right%;
                top: {$top}px;
                color: $clickCol;
                $clickBkg
                padding: 5px;
                border-radius: 5px;
                z-index: 9999;
            }

            #responsive-menu #responsiveSearch
            {
                display: block;
                width: 95%;
                padding-left: 5%;
                border-top: 1px solid $borCol !important; 
                clear: both;
                padding-top: 10px;
                padding-bottom: 10px;
                height: 40px;
                line-height: 40px;
            }

            #responsive-menu #responsiveSearchInput
            {
                width: 91%;
                padding: 5px 0px 5px 3%;
                -webkit-appearance: none;
                border-radius: 2px;
            }
  
            #responsive-menu .responsive-menu,
            #responsive-menu div,
            #responsive-menu .responsive-menu li
            {
                width: 100%;
                float: left !important;
                margin-left: 0px !important;
            }

            #responsive-menu .responsive-menu li li a
            {
                padding-left: 10% !important;
                width: 90% !important;
                overflow: hidden !important;
            }
 
            #responsive-menu .responsive-menu li li li a
            {
                padding-left: 15% !important;
                width: 85% !important;
                overflow: hidden !important;
            }
            
            #responsive-menu .responsive-menu li li li li
            {
                display: none;
            }
            
            #responsive-menu .responsive-menu li a:hover
            {       
                background: $mainBkgH !important;
                color: $txtColH !important;
                list-style-type: none !important
                text-decoration: none !important;;
            }
            
            #click-menu .threeLines
            {
                width: 33px;
                height: 33px;
                margin: auto;
            }

            #click-menu .threeLines .line
            {
                height: 5px;
                margin-bottom: 6px;
                background: $clickCol;
                width: 100%;
            }

            @media only screen and ( min-width : 0px ) and ( max-width : {$breakpoint}px ) { 

                #click-menu	
                {
                    display: block;
                }

";

                $css .= $options['RMCss'] ? $options['RMCss'] .  " { display: none !important; } " : '';
                $css .= $options['RMDepth'] == 1 ? " #responsive-menu .responsive-menu li li { display: none; } " : '';
                $css .= $options['RMDepth'] == 2 ? " #responsive-menu .responsive-menu li li li { display: none; } " : '';
                
        $css .= "   }

        </style>";

        return $css;

    }
    
    private static function checkViewPortTag() {

        $metaTags = get_meta_tags( get_bloginfo( 'url' ) );
        
        if( $metaTags['viewport'] ) return $metaTags['viewport'];
                          
    }
    
    private static function filterInput( $input ) {
        
        return stripslashes( strip_tags( trim( $input ) ) );
        
    }
    
}