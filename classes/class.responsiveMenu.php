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
                    'responsiveMenuImage' => '',
                    'responsiveMenuWidth' => '75',
                    'responsiveMenuMainBackground' => '#43494C',
                    'responsiveMenuMainBackgroundHover' => '#3C3C3C' ,
                    'responsiveMenuMainTitleColour' => '#FFFFFF',
                    'responsiveMenuMainTextColour' => '#FFFFFF',
                    'responsiveMenuMainBorderColour' => '#3C3C3C',
                    'responsiveMenuMainTextColourHover' => '#FFFFFF',
                    'responsiveMenuMainTitleColourHover' => '#FFFFFF'
                  
            ) ) );    
        
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
            
                        <div class="responsiveMenuTitle">Menu Width</div> 
            
            <div class="responsiveMenuDescription">This is the width the menu takes up across the page once expanded.</div>
            
            <input class="numberInput" type="text" name="responsiveMenuWidth" value="<?php echo isset( $options['responsiveMenuWidth'] ) ? $options['responsiveMenuWidth'] : ''; ?>" />%
            
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
            
            <table>
                <tr>
                    <td>
                
            <div class="responsiveMenuTitle">Menu Line & Text Colour</div> 
            
            <div class="responsiveMenuDescription">This is the colour of the 3 lines and text for the menu button</div>
            
            <input 
                type="text" 
                name="responsiveMenuLineColour" 
                id="responsiveMenuLineColour" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['responsiveMenuLineColour'] ); ?>" 
            />
                    </td>
                    <td>
            <div class="responsiveMenuTitle">Menu Button Background Colour</div> 
            
            <div class="responsiveMenuDescription">This is the background colour of the 3 lines container</div>
            
            <input 
                type="text" 
                name="responsiveMenuBackgroundColour" 
                id="responsiveMenuBackgroundColour" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['responsiveMenuBackgroundColour'] ); ?>" 
            />
                    </td>
            </tr>
                <tr>
                    <td>
                
            <div class="responsiveMenuTitle">Menu Background Colour</div> 
            
            <div class="responsiveMenuDescription">This is the background colour of the expanded menu</div>
            
            <input 
                type="text" 
                name="responsiveMenuMainBackground" 
                id="responsiveMenuMainBackground" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['responsiveMenuMainBackground'] ); ?>" 
            />
                    </td>
                    <td>
            <div class="responsiveMenuTitle">Menu Background Hover Colour</div> 
            
            <div class="responsiveMenuDescription">This is the hover background colour of the expanded menu</div>
            
            <input 
                type="text" 
                name="responsiveMenuMainBackgroundHover" 
                id="responsiveMenuMainBackgroundHover" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['responsiveMenuMainBackgroundHover'] ); ?>" 
            />
                    </td>
            </tr>
                            <tr>

                                        <td>
                
            <div class="responsiveMenuTitle">Menu Title Colour</div> 
            
            <div class="responsiveMenuDescription">This is the text colour of the expanded menu title</div>
            
            <input 
                type="text" 
                name="responsiveMenuMainTitleColour" 
                id="responsiveMenuMainTitleColour" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['responsiveMenuMainTitleColour'] ); ?>" 
            />
                    </td>
                    
                                        <td>
                
            <div class="responsiveMenuTitle">Menu Title Hover Colour</div> 
            
            <div class="responsiveMenuDescription">This is the hover colour of the expanded menu title</div>
            
            <input 
                type="text" 
                name="responsiveMenuMainTitleColourHover" 
                id="responsiveMenuMainTitleColourHover" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['responsiveMenuMainTitleColourHover'] ); ?>" 
            />
                    </td>
                            </tr>
                            <tr>
                    <td>
            <div class="responsiveMenuTitle">Menu Text Colour</div> 
            
            <div class="responsiveMenuDescription">This is the text colour of the expanded menu links</div>
            
            <input 
                type="text" 
                name="responsiveMenuMainTextColour" 
                id="responsiveMenuMainTextColour" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['responsiveMenuMainTextColour'] ); ?>" 
            />
                    </td>
                                        <td>
            <div class="responsiveMenuTitle">Menu Text Hover Colour</div> 
            
            <div class="responsiveMenuDescription">This is the text hover colour of the expanded menu links</div>
            
            <input 
                type="text" 
                name="responsiveMenuMainTextColourHover" 
                id="responsiveMenuMainTextColourHover" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['responsiveMenuMainTextColourHover'] ); ?>" 
            />
                    </td>
            </tr>
                                        <tr>
                    <td>
                
            <div class="responsiveMenuTitle">Menu Link Border Colour</div> 
            
            <div class="responsiveMenuDescription">This is the border colour of the expanded menu titles</div>
            
            <input 
                type="text" 
                name="responsiveMenuMainBorderColour" 
                id="responsiveMenuMainBorderColour" 
                class="colourPicker" 
                value="<?php echo stripslashes( $options['responsiveMenuMainBorderColour'] ); ?>" 
            />
                    </td>
                    <td>
            
                    </td>
            </tr>
                <tr>
                    <td>
            <div class="responsiveMenuTitle">Menu Background Transparent</div> 
            
            <div class="responsiveMenuDescription">Tick this if you would like a transparent background</div>
            
            <input 
                type="checkbox" 
                name="responsiveMenuBackgroundTransparent" 
                id="responsiveMenuBackgroundTransparent"
                value="checked"
                <?php echo $options['responsiveMenuBackgroundTransparent'] == 'checked' ? ' checked="checked" ' : ''; ?>
            />
                    </td><td>
            <div class="responsiveMenuTitle">Fixed Positioning</div> 
            
            <div class="responsiveMenuDescription">Tick this if you would like the menu button to remain in the same place when scrolling.</div>
            
            <input 
                type="checkbox" 
                name="responsiveMenuFixed" 
                id="responsiveMenuFixed"
                value="fixed"
                <?php echo $options['responsiveMenuFixed'] == 'fixed' ? ' checked="checked" ' : ''; ?>
            />
                                </td>
            </tr>
            </table>
            
            <div class="responsiveMenuTitle">Font</div> 
            
            <div class="responsiveMenuDescription">Enter your preferred font name below, if empty your default site font will be used.</div>
            
            <input type="text" name="responsiveMenuFont" value="<?php echo isset( $options['responsiveMenuFont'] ) ? $options['responsiveMenuFont'] : ''; ?>" />
            
            <br /><br />
            
            <input type="submit" class="button button-primary" name="responsiveMenuSubmit" value="Update Responsive Menu Options" />
            
        </form>
        
    </div>

<?php        
         
    }
    
    private static function validate() {
        
        if( isset( $_POST['responsiveMenuSubmit'] ) ) :
            
            $responsiveMenuMainBackground = isset( $_POST['responsiveMenuMainBackground'] ) ? $_POST['responsiveMenuMainBackground'] : '#43494C';
            $responsiveMenuMainBackgroundHover = isset( $_POST['responsiveMenuMainBackgroundHover'] ) ? $_POST['responsiveMenuMainBackgroundHover'] : '#3C3C3C';
            $responsiveMenuMainTitleColour = isset( $_POST['responsiveMenuMainTitleColour'] ) ? $_POST['responsiveMenuMainTitleColour'] : '#FFFFFF';
            $responsiveMenuMainTextColour = isset( $_POST['responsiveMenuMainTextColour'] ) ? $_POST['responsiveMenuMainTextColour'] : '#FFFFFF';
            $responsiveMenuMainBorderColour = isset( $_POST['responsiveMenuMainBorderColour'] ) ? $_POST['responsiveMenuMainBorderColour'] : '#3C3C3C';                
         
            $responsiveMenuMainTextColourHover = isset( $_POST['responsiveMenuMainTextColourHover'] ) ? $_POST['responsiveMenuMainTextColourHover'] : '#FFFFFF'; 
                        $responsiveMenuMainTitleColourHover = isset( $_POST['responsiveMenuMainTitleColourHover'] ) ? $_POST['responsiveMenuMainTitleColourHover'] : '#FFFFFF'; 
            
            
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
                    'responsiveMenuImage' => stripslashes( strip_tags( trim( $_POST['responsiveMenuImage'] ) ) ),
                    'responsiveMenuWidth' => intval( $_POST['responsiveMenuWidth'] ),
                    'responsiveMenuMainBackground' => stripslashes( strip_tags( trim( $responsiveMenuMainBackground ) ) ),
                    'responsiveMenuMainBackgroundHover' => stripslashes( strip_tags( trim( $responsiveMenuMainBackgroundHover ) ) ),
                    'responsiveMenuMainTitleColour' => stripslashes( strip_tags( trim( $responsiveMenuMainTitleColour ) ) ),
                    'responsiveMenuMainTextColour' => stripslashes( strip_tags( trim( $responsiveMenuMainTextColour ) ) ),
                    'responsiveMenuMainBorderColour' => stripslashes( strip_tags( trim( $responsiveMenuMainBorderColour ) ) ),
                    'responsiveMenuMainTextColourHover' => stripslashes( strip_tags( trim( $responsiveMenuMainTextColourHover ) ) ),
                    'responsiveMenuMainTitleColourHover' => stripslashes( strip_tags( trim( $responsiveMenuMainTitleColourHover ) ) ),
                    
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

            $( '#click-menu' ).click( function() { ";
                        
            $js .= $options['responsiveMenuFixed'] == 'fixed' ? "" : " $( '#responsive-menu' ).css( 'height', $( document ).height() ); ";
        
             $js .= "if( !isOpen ) {
                
                      $( '#responsive-menu' ).css( 'display', 'block' ); 
                      $( '#responsive-menu' ).stop().animate( { left: \"0\" }, 500 ); 
                      
                      isOpen = true;

                } else {
                
                        $( '#responsive-menu' ).animate( { left: \"-1000\" }, 500, function() { 
                      
                            $( '#responsive-menu' ).css( 'display', 'none' );  

                        } );
                      
                      isOpen = false;
                      
                }

                // Close Responive Menu If Browser Width Goes Above {$options['responsiveMenuBreakpoint']}px
                    
                $( window ).resize(function() { ";

               $js .= $options['responsiveMenuFixed'] == 'fixed' ? "" : " $( '#responsive-menu' ).css( 'height', $( document ).height() ); ";
                
               $js .= "if( $( document ).width() > {$options['responsiveMenuBreakpoint']} ) { 

                        if( $( '#responsive-menu' ).css( 'left' ) != '-1000px' ) {

                        $( '#responsive-menu' ).animate( { left: \"-1000\" }, 500, function() { 
                      
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
      
        $options = unserialize( get_option( 'responsive_menu_options' ) );
        
        $html = '
            <div id="responsive-menu">
			
                <div id="responsive-menu-title">';
        
        $html .= $options['responsiveMenuImage'] ? '<div class="responsiveMenuImageContainer"><a href="' . get_site_url() . ' "><img src="' . $options['responsiveMenuImage'] . '" class="responsiveMenuImage" /></a></div>' : '';

        $html .= '<a href="' . get_site_url() . ' ">' . $options['responsiveMenuTitle'] . '</a></div>';
						
        $html .= wp_nav_menu( array( 
            'menu' => $options['reponsiveMenuMenu'], 
            'echo' => false, 
            'menu_class' => 'responsive-menu' ) );
		
        $html .= '<form action="/" id="responsiveSearch" method="get" role="search">

                    <input type="text" name="s" value="" placeholder="Search" id="responsiveSearchInput">

                </form>';
        
       $html .= $options['responsiveMenuFixed'] == 'fixed' ? '<div style="height: 110px;"></div>' : '';
            
          $html .= '</div>';
        
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
                margin-right: 5px;
            }

            #responsive-menu .responsiveMenuImage
            {
                width: 100%;
                vertical-align: sub;
            }

            #responsive-menu								
            { ";
        
        $css .= $options['responsiveMenuFixed'] == 'fixed' ? "position: fixed; overflow-y: scroll; bottom: 0px;" : "position: absolute; ";
        
        $css .= empty( $options['responsiveMenuWidth'] ) ? "width: 75%;" : "width: " . $options['responsiveMenuWidth'] . "%;";
        
        $css .= "top: 0px; 
                left: -1000px; ";
        
        $css .= empty( $options['responsiveMenuMainBackground'] ) ? "background: #43494C; " : "background: " . $options['responsiveMenuMainBackground'] . ";";	
                    
                    $css .= "
                z-index: 9999;  
                box-shadow: 0px 1px 8px #333333; 
                font-size: 13px;
                max-width: 999px;
                display: none;
                color: white;";
        
        $css .= !empty( $options['responsiveMenuFont'] ) ? 'font-family: "' . $options['responsiveMenuFont'] . '";' : '';
                
        $css .="
            }";
        
        $css .= !empty( $options['responsiveMenuFont'] ) ? ' #responsive-menu input { font-family: "' . $options['responsiveMenuFont'] . '"; } ' : '';

        $css .= "
            #responsive-menu #responsive-menu-title			
            { ";
        
        $css .= !empty( $options['responsiveMenuMainTitleColour'] ) ? 'color: ' . $options['responsiveMenuMainTitleColour'] . ' !important;' : 'color: #FFFFFF !important;';
        
        $css .= "
                width: 95%; 
                font-size: 14px; 
                padding: 20px 0px 20px 5%;
                margin-left: 0px;
                line-height: 32px;
            }
  
#responsive-menu #responsive-menu-title a {";
    
        $css .= !empty( $options['responsiveMenuMainTitleColour'] ) ? 'color: ' . $options['responsiveMenuMainTitleColour'] . ' !important;' : 'color: #FFFFFF !important;';

           $css .= " }
            
#responsive-menu #responsive-menu-title a:hover {";
    
        $css .= !empty( $options['responsiveMenuMainTitleColourHover'] ) ? 'color: ' . $options['responsiveMenuMainTitleColourHover'] . ' !important;' : 'color: #FFFFFF !important;';
        
        $css .= "
            
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
                white-space: nowrap !important; ";
        
        $css .= empty( $options['responsiveMenuMainTextColour'] ) ? "color: #FFFFFF !important;" : "color: " . $options['responsiveMenuMainTextColour'] . " !important;";
        
        $css .= "border-top: 1px solid ";
        
        $css .= empty( $options['responsiveMenuMainBorderColour'] ) ? "#3C3C3C" : $options['responsiveMenuMainBorderColour'];
        
        $css .= " !important; 
                text-decoration: none !important;
            }

            #click-menu						
            { 
                text-align: center;
                cursor: pointer; 
                width: 50px;
                font-size: 13px;
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
                border-top: 1px solid ";
        
                $css .= empty( $options['responsiveMenuMainBorderColour'] ) ? "#3C3C3C" : $options['responsiveMenuMainBorderColour'];

            $css .= " !important; 
                clear: both;
                padding-top: 10px;
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
            { ";
            
            $css .= empty( $options['responsiveMenuMainBackgroundHover'] ) ? "background: #3C3C3C !important; " : "background: " . $options['responsiveMenuMainBackgroundHover'] . " !important; ";
            
        $css .= empty( $options['responsiveMenuMainTextColourHover'] ) ? "color: #FFFFFF !important;" : 'color: ' . $options['responsiveMenuMainTextColourHover'] . ' !important; ';

        $css .= " list-style-type: none !important
            text-decoration: none !important;;
            }";
                
                if( $options['reponsiveMenuDepth'] == 1) $css .= " #responsive-menu .responsive-menu li li { display: none; } ";
                if( $options['reponsiveMenuDepth'] == 2) $css .= " #responsive-menu .responsive-menu li li li { display: none; } ";
                
                $css .= "
            
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