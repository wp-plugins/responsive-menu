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

        update_option( 'RMVer', '1.7' );

            add_option('RMOptions', serialize(array(
                'RM' => '',
                'RMBreak' => 400,
                'RMDepth' => 2,
                'RMTop' => 10,
                'RMRight' => 5,
                'RMCss' => '',
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
                'RMExpand' => false
            )));

    }

    static function menus() {

        add_menu_page( 'Responsive Menu', 'Responsive Menu', 'manage_options', 'responsive-menu', array('ResponsiveMenu', 'adminPage'), RM_IMAGES . 'icon.png' );

    }

    public static function adminPage() {

            if ( get_option('responsive_menu_options') && !get_option( 'RMVer' ) ) :

            update_option( 'RMVer', '1.7' );
            
            // Migrate Old Data 
            $options = unserialize(get_option('responsive_menu_options'));

                add_option('RMOptions', serialize(array(
                    'RM' => $options['reponsiveMenuMenu'],
                    'RMBreak' => $options['responsiveMenuBreakpoint'],
                    'RMDepth' => $options['reponsiveMenuDepth'],
                    'RMTop' => $options['responsiveMenuTop'],
                    'RMRight' => $options['responsiveMenuRight'],
                    'RMCss' => $options['responsiveMenuCss'],
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
                    'RMBkgHov' => $options['responsiveMenuMainBackgroundHover'],
                    'RMTitleCol' => $options['responsiveMenuMainTitleColour'],
                    'RMTextCol' => $options['responsiveMenuMainTextColour'],
                    'RMBorCol' => $options['responsiveMenuMainBorderColour'],
                    'RMTextColHov' => $options['responsiveMenuMainTextColourHover'],
                    'RMTitleColHov' => $options['responsiveMenuMainTitleColourHover'],
                    
                    /* Added in 1.6 */
                    'RMAnim' => 'overlay',
                    'RMPushCSS' => '',
                    'RMTitleBkg' => '#43494C',
                    'RMFontSize' => 13,
                    'RMTitleSize' => 14,
                    'RMBtnSize' => 13,
                    'RMCurBkg' => $options['responsiveMenuMainBackground'],
                    'RMCurCol' => $options['responsiveMenuMainTextColour'],
                    'RMAnimSpd' => 0.5,
                    
                    /* Added in 1.7 */
                    'RMTranSpd' => 1,
                    'RMTxtAlign' => 'left',
                    'RMSearch' => false,
                    'RMExpand' => false
                )));
            
            endif;
       
        if (isset($_POST['RMSubmit'])) :

            $validated = self::validate();

        endif;

        $options = unserialize(get_option('RMOptions'));
             
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
            
            .default
            {
                font-size: 8px;
                font-style: italic;
            }

            .error
            {
                color: red;
            }
            
            .success
            {
                color: green;
            }
            
            @media only screen and ( min-width : 0px ) and ( max-width : 600px ) { 

                table, table td, table tr
                {
                    width: 100%;
                    display: block;
                }
                
            }
            
        </style>

        <script>

            jQuery(document).ready(function($) {

                $('.colourPicker').wpColorPicker( );

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

                <?php if (isset($validated)) : ?>

                    <div id="message" class="updated below-h2 cookieBannerSuccess"><p>Your Responsive Menu Options have been updated.</p></div>

                <?php endif; ?>

                <hr />

                <h3>Initial Checks</h3>

                <h4>Viewport Meta Tag Check<?php if ( $portTag = self::checkViewPortTag() ) : ?><span class='success'> - Below Viewport Meta Tag Found</span><?php else : $portTag = null; endif; ?></h4> 

                <?php
                if ( $portTag ) :
                    echo "&lt;meta name='viewport' content='" . self::checkViewPortTag() . "' /&gt;";
                else :
                    echo "<span class='error'>Viewport Meta Tag Not Found</span>";
                endif;
                ?>

                <h4>Recommended</h4>
                &lt;meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' /&gt;
                <br /><br />

                <hr />

                <h3>Menu Settings</h3>

                <table>
                    <tr>
                        <td>

                            <h4>Menu Title</h4> 

                            <h5>This is the title at the top of the responsive menu</h5>

                            <input type="text" name="RMTitle" value="<?php echo isset($options['RMTitle']) ? $options['RMTitle'] : ''; ?>" />

                        </td>
                        <td>

                            <h4>Menu Image</h4> 

                            <h5>This is the image that sits next to the responsive menu title. The best size is 32px x 32px</h5>

                            <input type="text" id="RMImage" name="RMImage" value="<?php echo isset($options['RMImage']) ? $options['RMImage'] : ''; ?>" />
                            <input type="button" id="RMImageButton" value="Upload Image" class="button" />

                        </td>
                    <tr>
                        <td>
                            <h4>Menu Button Title</h4> 

                            <h5>This is the title under the 3 lines of the menu button</h5>

                            <input type="text" name="RMClickTitle" value="<?php echo isset($options['RMClickTitle']) ? $options['RMClickTitle'] : ''; ?>" />
                        </td>
                        <td>
                            <h4>Choose Menu To Responsify</h4> 

                            <h5>This is the menu that will be used responsively.</h5>

                            <?php if (count(get_terms('nav_menu')) > 0) : ?>

                                <select name="RM">

                                    <?php foreach (get_terms('nav_menu') as $menu) : ?>

                                        <option value="<?php echo $menu->slug; ?>"<?php echo $menu->slug == $options['RM'] ? 'selected="selected">' : '>'; ?>
                                        <?php echo $menu->name; ?>
                                    </option>

                                <?php endforeach; ?>

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

                        <input class="numberInput" type="text" name="RMBreak" value="<?php echo isset($options['RMBreak']) ? $options['RMBreak'] : ''; ?>" />px

                    </td>
                    <td>
                        <h4>CSS of Menu To Hide</h4> 

                        <h5>This is the CSS of the menu you want to hide once the responsive menu shows - e.g #primary-nav, .menu</h5>

                        <input type="text" name="RMCss" value="<?php echo isset($options['RMCss']) ? $options['RMCss'] : ''; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>Menu Depth</h4> 

                        <h5>This is how deep into your menu tree will be visible (max 3)</h5>

                        <select name="RMDepth">

                            <?php for ($i = 1; $i < 4; $i++) : ?>

                                <option value="<?php echo $i; ?>"<?php echo $i == $options['RMDepth'] ? 'selected="selected">' : '>'; ?>
                                <?php echo $i; ?>
                            </option>

                        <?php endfor; ?>

                    </select>
                </td>
                <td>
                    <h4>Menu Width</h4> 

                    <h5>This is the width the menu takes up across the page once expanded. <span class="default">default: 75</span></h5>

                    <input class="numberInput" type="text" name="RMWidth" value="<?php echo isset($options['RMWidth']) ? $options['RMWidth'] : ''; ?>" />%

                </td>
                </tr>
                
                <tr>
                    <td>
                        
                        <h4>Remove Search Box</h4> 

                        <h5>Tick if you would like to remove the search box</h5>

                    <input 
                        type="checkbox" 
                        name="RMSearch" 
                        id="RMSearch"
                        value="search"
                        <?php echo $options['RMSearch'] == 'search' ? ' checked="checked" ' : ''; ?>
                        />
                    
                </td>
                <td>
                    
                        <h4>Auto Expand Sub-Menus</h4> 

                        <h5>Tick if you would like sub-menus to be automatically expanded</h5>

                    <input 
                        type="checkbox" 
                        name="RMExpand" 
                        id="RMExpand"
                        value="expand"
                        <?php echo $options['RMExpand'] == 'expand' ? ' checked="checked" ' : ''; ?>
                        />

                </td>
                
                </tr>
                
                </table>
        <hr />
                
        <h3>Location Settings</h3>

        <table>
            <tr>
                <td>
                    <h4>Top</h4> 

                    <h5>This is the distance from the top of the page in px that the menu will be displayed</h5>

                    <input class="numberInput" type="text" name="RMTop" value="<?php echo isset($options['RMTop']) ? $options['RMTop'] : ''; ?>" />px
                </td>
                <td>

                    <h4>Right</h4> 

                    <h5>This is the distance from the right of the page in percentage that the menu will be displayed</h5>

                    <input class="numberInput" type="text" name="RMRight" value="<?php echo isset($options['RMRight']) ? $options['RMRight'] : ''; ?>" />%

                </td>
            </tr></table>
        <hr />

        <h3>Colour Settings</h3>

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
                        value="<?php echo isset($options['RMLineCol']) ? $options['RMLineCol'] : ''; ?>" 
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
                        value="<?php echo isset($options['RMClickBkg']) ? $options['RMClickBkg'] : ''; ?>" 
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
                        value="<?php echo isset($options['RMBkg']) ? $options['RMBkg'] : ''; ?>" 
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
                        value="<?php echo isset($options['RMBkgHov']) ? $options['RMBkgHov'] : ''; ?>" 
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
                        value="<?php echo isset($options['RMTitleCol']) ? $options['RMTitleCol'] : ''; ?>" 
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
                        value="<?php echo isset($options['RMTitleColHov']) ? $options['RMTitleColHov'] : ''; ?>" 
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
                        value="<?php echo isset($options['RMTextCol']) ? $options['RMTextCol'] : ''; ?>" 
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
                        value="<?php echo isset($options['RMTextColHov']) ? $options['RMTextColHov'] : ''; ?>" 
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
                        value="<?php echo isset($options['RMBorCol']) ? $options['RMBorCol'] : ''; ?>" 
                        />
                </td>
                <td>
                    <h4>Title Background Colour</h4> 

                    <h5>This is the background colour of the expanded menu title</h5>

                    <input 
                        type="text" 
                        name="RMTitleBkg" 
                        id="RMTitleBkg" 
                        class="colourPicker" 
                        value="<?php echo isset( $options['RMTitleBkg'] ) ? $options['RMTitleBkg'] : ''; ?>" 
                        />
                </td>
            </tr>
            <tr>
                <td>

                    <h4>Current Page Background Colour</h4> 

                    <h5>This is the background colour of the current page</h5>

                    <input 
                        type="text" 
                        name="RMCurBkg" 
                        id="RMCurBkg" 
                        class="colourPicker" 
                        value="<?php echo isset($options['RMCurBkg']) ? $options['RMCurBkg'] : ''; ?>" 
                        />
                </td>
                <td>
                    <h4>Current Page Text Colour</h4> 

                    <h5>This is the text colour of the current page</h5>

                    <input 
                        type="text" 
                        name="RMCurCol" 
                        id="RMCurCol" 
                        class="colourPicker" 
                        value="<?php echo isset($options['RMCurCol']) ? $options['RMCurCol'] : ''; ?>" 
                        />
                </td>
            </tr>
        </table>
        
        <hr />
        
        <h3>Style Settings</h3>
        
        <table>
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

                    <input type="text" name="RMFont" value="<?php echo isset($options['RMFont']) ? $options['RMFont'] : ''; ?>" />

                </td>
                <td>                    
                    <h4>Font Size</h4> 

                    <h5>Enter a font size in pixels below. <span class='default'>default: 13</span></h5>

                    <input type="text" name="RMFontSize" class="numberInput" value="<?php echo isset($options['RMFontSize']) ? $options['RMFontSize'] : ''; ?>" />px
                </td>
            </tr>
            
            <tr>
                <td>
               <h4>Click Button Font Size</h4> 

                    <h5>Enter a click button font size in pixels below. <span class='default'>default: 13</span></h5>

                    <input type="text" name="RMBtnSize" class="numberInput" value="<?php echo isset($options['RMBtnSize']) ? $options['RMBtnSize'] : ''; ?>" />px

                </td>
                <td>                    
                    <h4>Title Font Size</h4> 

                    <h5>Enter a title font size in pixels below. <span class='default'>default: 14</span></h5>

                    <input type="text" name="RMTitleSize" class="numberInput" value="<?php echo isset($options['RMTitleSize']) ? $options['RMTitleSize'] : ''; ?>" />px
                </td>
            </tr>
            
            <tr>
                <td>
                    
                    <h4>Text Alignment</h4> 

                    <h5>Enter a text alignment option below <span class='default'>default: left</span></h5>

                    <select name="RMTxtAlign">

                        <option value="left"<?php echo 'overlay' == $options['RMTxtAlign'] ? ' selected="selected " ' : ''; ?>>Left</option>
                        <option value="center"<?php echo 'center' == $options['RMTxtAlign'] ? ' selected="selected " ' : ''; ?>>Centre</option>  
                        <option value="right"<?php echo 'right' == $options['RMTxtAlign'] ? ' selected="selected " ' : ''; ?>>Right</option> 

                    </select>

                </td>
                
                <td>                    

                </td>
            </tr>
            
        </table>

        <hr />        


        <h3>Animation Settings</h3>

        <?php if( $options['RMAnim'] == 'push' && $portTag != 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' ) : ?>

            <span class='error'>Warning: The Push Animation requires you to place the following meta tag in your site header:</span><br />
            <span class='success'>&lt;meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" /&gt;</span>
        
        <?php endif; ?>
        
        <table>
            <tr>
                <td>

                    <h4>Slide Animation</h4> 

                    <h5>Choose the type of animation applied to the menu</h5>

                    <select name="RMAnim">

                        <option value="overlay"<?php echo 'overlay' == $options['RMAnim'] ? ' selected="selected " ' : ''; ?>>Overlay</option>
                        <option value="push"<?php echo 'push' == $options['RMAnim'] ? ' selected="selected " ' : ''; ?>>Push</option>      

                    </select>

                </td>
                <td>

                    <h4>Page Wrappers CSS</h4> 

                    <h5>This is the css ID or class of the wrapper you want to push when using the push animation (e.g - #pushWrapper, .pushContainer)</h5>

                    <input type="text" name="RMPushCSS" value="<?php echo isset($options['RMPushCSS']) ? $options['RMPushCSS'] : ''; ?>" />

                </td>
            </tr>
                        <tr>
                <td>

                    <h4>Animation Speed</h4> 

                    <h5>Enter a speed in seconds below of the slide animation. <span class="default">default: 0.5</span></h5>

                    <input type="text" name="RMAnimSpd" class="numberInput" value="<?php echo isset($options['RMAnimSpd']) ? $options['RMAnimSpd'] : ''; ?>" />s

                </td>
                <td>
                    
                    <h4>Transition Speed</h4> 

                    <h5>Enter a speed in seconds below of the hover transition effect. <span class="default">default: 1</span></h5>

                    <input type="text" name="RMTranSpd" class="numberInput" value="<?php echo isset($options['RMTranSpd']) ? $options['RMTranSpd'] : ''; ?>" />s
                </td>
            </tr>
        </table>
 
        <br /><br />

        <input type="submit" class="button button-primary" name="RMSubmit" value="Update Responsive Menu Options" />

        </form>

        </div>

        <?php
    }

    private static function validate() {

        if (isset($_POST['RMSubmit'])) :

            // Initialise Variables Correctly
            $RM = isset($_POST['RM']) ? $_POST['RM'] : '';
            $RMTitle = isset($_POST['RMTitle']) ? $_POST['RMTitle'] : '';
            $RMBreak = isset($_POST['RMBreak']) ? $_POST['RMBreak'] : '';
            $RMDepth = isset($_POST['RMDepth']) ? $_POST['RMDepth'] : '1';
            $RMTop = isset($_POST['RMTop']) ? $_POST['RMTop'] : '';
            $RMRight = isset($_POST['RMRight']) ? $_POST['RMRight'] : '';
            $RMCss = isset($_POST['RMCss']) ? $_POST['RMCss'] : '';
            $RMLineCol = isset($_POST['RMLineCol']) ? $_POST['RMLineCol'] : '';
            $RMClickBkg = isset($_POST['RMClickBkg']) ? $_POST['RMClickBkg'] : '';
            $RMClickTitle = isset($_POST['RMClickTitle']) ? $_POST['RMClickTitle'] : '';
            $RMBkgTran = isset($_POST['RMBkgTran']) ? $_POST['RMBkgTran'] : '';
            $RMPos = isset($_POST['RMPos']) ? $_POST['RMPos'] : '';
            $RMImage = isset($_POST['RMImage']) ? $_POST['RMImage'] : '';
            $RMWidth = isset($_POST['RMWidth']) ? $_POST['RMWidth'] : '75';
            $RMBkg = isset($_POST['RMBkg']) ? $_POST['RMBkg'] : '#43494C';
            $RMBkgHov = isset($_POST['RMBkgHov']) ? $_POST['RMBkgHov'] : '#3C3C3C';
            $RMTitleCol = isset($_POST['RMTitleCol']) ? $_POST['RMTitleCol'] : '#FFFFFF';
            $RMTextCol = isset($_POST['RMTextCol']) ? $_POST['RMTextCol'] : '#FFFFFF';
            $RMBorCol = isset($_POST['RMBorCol']) ? $_POST['RMBorCol'] : '#3C3C3C';
            $RMTextColHov = isset($_POST['RMTextColHov']) ? $_POST['RMTextColHov'] : '#FFFFFF';
            $RMTitleColHov = isset($_POST['RMTitleColHov']) ? $_POST['RMTitleColHov'] : '#FFFFFF';
            
            /* Added in 1.6 */
            $RMAnim = isset($_POST['RMAnim']) ? $_POST['RMAnim'] : 'overlay';
            $RMPushCSS = isset($_POST['RMPushCSS']) ? $_POST['RMPushCSS'] : '';
            $RMTitleBkg = isset($_POST['RMTitleBkg']) ? $_POST['RMTitleBkg'] : '#43494C';
            $RMFont =  isset($_POST['RMFont']) ? $_POST['RMFont'] : '';
            $RMFontSize = isset($_POST['RMFontSize']) ? $_POST['RMFontSize'] : 13;
            $RMTitleSize = isset($_POST['RMTitleSize']) ? $_POST['RMTitleSize'] : 14;
            $RMBtnSize = isset($_POST['RMBtnSize']) ? $_POST['RMBtnSize'] : 13;
            $RMCurBkg = isset($_POST['RMCurBkg']) ? $_POST['RMCurBkg'] : $RMBkg;
            $RMCurCol = isset($_POST['RMCurCol']) ? $_POST['RMCurCol'] : $RMTextCol;
            $RMAnimSpd = isset($_POST['RMAnimSpd']) ? $_POST['RMAnimSpd'] : 0.5;
            
            /* Added in 1.7 */
            $RMTranSpd = isset($_POST['RMTranSpd']) ? $_POST['RMTranSpd'] : 1;
            $RMTxtAlign = isset($_POST['RMTxtAlign']) ? $_POST['RMTxtAlign'] : 'left';
            $RMSearch = isset($_POST['RMSearch']) ? $_POST['RMSearch'] : false;
            $RMExpand = isset($_POST['RMExpand']) ? $_POST['RMExpand'] : false;
                    
            // Update Submitted Options 
            update_option('RMOptions',
                    // Serialize For Database
                    serialize(array(
                // Filter Input Correctly
                'RM' => self::filterInput($RM),
                'RMBreak' => intval($RMBreak),
                'RMDepth' => intval($RMDepth),
                'RMTop' => intval($RMTop),
                'RMRight' => intval($RMRight),
                'RMCss' => self::filterInput($RMCss),
                'RMTitle' => self::filterInput($RMTitle),
                'RMLineCol' => self::filterInput($RMLineCol),
                'RMClickBkg' => self::filterInput($RMClickBkg),
                'RMClickTitle' => self::filterInput($RMClickTitle),
                'RMBkgTran' => self::filterInput($RMBkgTran),
                'RMFont' => self::filterInput($RMFont),
                'RMPos' => self::filterInput($RMPos),
                'RMImage' => self::filterInput($RMImage),
                'RMWidth' => intval($RMWidth),
                'RMBkg' => self::filterInput($RMBkg),
                'RMBkgHov' => self::filterInput($RMBkgHov),
                'RMTitleCol' => self::filterInput($RMTitleCol),
                'RMTextCol' => self::filterInput($RMTextCol),
                'RMBorCol' => self::filterInput($RMBorCol),
                'RMTextColHov' => self::filterInput($RMTextColHov),
                'RMTitleColHov' => self::filterInput($RMTitleColHov),
                        
                /* Added in 1.6 */
                'RMAnim' => self::filterInput($RMAnim),
                'RMPushCSS' => self::filterInput($RMPushCSS),
                'RMTitleBkg' => self::filterInput( $RMTitleBkg ),
                'RMFontSize' => intval( $RMFontSize ),
                'RMTitleSize' => intval( $RMTitleSize ),
                'RMBtnSize' => intval( $RMBtnSize ),
                'RMCurBkg' => self::filterInput( $RMCurBkg ),
                'RMCurCol' => self::filterInput( $RMCurCol ),
                'RMAnimSpd' => floatval( $RMAnimSpd ),
                        
                /* Added in 1.7 */
                'RMTranSpd' => floatval( $RMTranSpd ),
                'RMTxtAlign' => self::filterInput( $RMTxtAlign ),
                'RMSearch' => self::filterInput( $RMSearch ),
                'RMExpand' => self::filterInput( $RMExpand )    
                    
            )));

            return true;

        else :

            return false;

        endif;
    }

    static function displayMenu() {

        echo self::getJavascript();
        echo self::getCSS();
        
    }

    static function displayMenuHtml() {
        
        echo self::getHTML();
        
    }
    
    
    static function Colorpicker(){ 
    
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker');
        wp_enqueue_script( 'wp-color-picker');

    }
    
    static function jQuery() { 
    
        wp_enqueue_script( 'jquery' );
  
    }
    
    static function getJavascript() {

        $options = unserialize(get_option('RMOptions'));

        $setHeight = $options['RMPos'] == 'fixed' ? '' : " $( '#responsive-menu' ).css( 'height', $( document ).height() ); ";
        $breakpoint = empty($options['RMBreak']) ? "400" : $options['RMBreak'];
        $width = empty($options['RMWidth']) ? "75" : $options['RMWidth'];
        $RMPushCSS = empty($options['RMPushCSS']) ? "" : $options['RMPushCSS'];

        $slideOpen = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " $( 'body' ).addClass( 'RMPushOpen' ); " : '';
        $slideRemove = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " $( 'body' ).removeClass( 'RMPushOpen' ); " : '';

        $slideOver = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " $( '$RMPushCSS' ).animate( { left: \"$width%\" }, 500, 'linear' ); " : '';
        $slideOverCss = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " $( '$RMPushCSS' ).addClass( 'RMPushSlide' ); " : '';

        $slideBack = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " $( '$RMPushCSS' ).animate( { left: \"0\" }, 500, 'linear' ); " : '';
        $slideOverCssRemove = $options['RMAnim'] == 'push' && !empty($options['RMPushCSS']) ? " $( '$RMPushCSS' ).removeClass( 'RMPushSlide' ); " : '';

        $speed = empty( $options['RMAnimSpd'] ) ? 500 : $options['RMAnimSpd'] * 1000; 
        
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
                      $( '#responsive-menu' ).stop().animate( { left: \"0\" }, $speed, 'linear', function() { 
                          
                        $setHeight
    
                      } ); 

                      isOpen = true;
                      
                      

                } else {

                        $slideBack
                        
                        $( '#responsive-menu' ).animate( { left: \"-{$width}%\" }, $speed, 'linear', function() { 
                      
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
                            
                        $( '#responsive-menu' ).animate( { left: \"-{$width}%\" }, $speed, 'linear', function() { 
                        
                            $slideRemove
                            $slideOverCssRemove                      
                            $( '#responsive-menu' ).css( 'display', 'none' );  

                        } );

                        }

                    }

                    });

                });

            ";
        
    /* Added 1.7 */
    if ( !$options['RMExpand'] ) : 

        $js .= " 
            
                clickLink = '<span class=\"appendLink\">&#9660;</span>';
                $( '#responsive-menu .responsive-menu .sub-menu' ).css( 'display', 'none' ); 
                $( '#responsive-menu .responsive-menu .menu-item-has-children' ).prepend( clickLink );
                
                $( '.appendLink' ).on( 'click', function() { 
                
                    $( this ).nextAll( 'ul.sub-menu' ).toggle( ); 

                } );
                ";

    endif;
    
        $js .= "}); </script>";

        echo $js;
    }

    static function getHTML() {

        $options = unserialize(get_option('RMOptions'));

        $html = '
            <div id="responsive-menu">
			
                <div id="responsive-menu-title">';

        $html .= $options['RMImage'] ? '<a href="' . get_site_url() . ' "><img src="' . $options['RMImage'] . '" class="RMImage" alt="' . $options['RMTitle'] . '" title="' . $options['RMTitle'] . '" /></a>' : '';


        $html .= '<a href="' . get_site_url() . ' ">' . $options['RMTitle'] . '</a></div>';

        $html .= wp_nav_menu(array(
            'menu' => $options['RM'],
            'echo' => false,
            'menu_class' => 'responsive-menu'));

        if( !$options['RMSearch'] ) : 
            
            $html .= '<form action="/" id="responsiveSearch" method="get" role="search">

                        <input type="text" name="s" value="" placeholder="Search" id="responsiveSearchInput">

                    </form>';
        
        endif;
                
        $html .= '</div>';

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

        $options = unserialize(get_option('RMOptions'));

        $position = $options['RMPos'] == 'fixed' ? 'fixed' : 'absolute';
        $overflowy = $options['RMPos'] == 'fixed' ? 'overflow-y: auto;' : '';
        $bottom = $options['RMPos'] == 'fixed' ? 'bottom: 0px;' : '';

        $right = empty($options['RMRight']) ? '0' : $options['RMRight'];
        $top = empty($options['RMTop']) ? '0' : $options['RMTop'];
        $width = empty($options['RMWidth']) ? '75' : $options['RMWidth'];
        $mainBkg = empty($options['RMBkg']) ? "#43494C" : $options['RMBkg'];
        $mainBkgH = empty($options['RMBkgHov']) ? "#3C3C3C" : $options['RMBkgHov'];
        $font = empty($options['RMFont']) ? '' : 'font-family: "' . $options['RMFont'] . '" !important;';
        $titleCol = empty($options['RMTitleCol']) ? '#FFFFFF' : $options['RMTitleCol'];
        $titleColH = empty($options['RMTitleColHov']) ? '#FFFFFF' : $options['RMTitleColHov'];
        $txtCol = empty($options['RMTextCol']) ? "#FFFFFF" : $options['RMTextCol'];
        $txtColH = empty($options['RMTextColHov']) ? "#FFFFFF" : $options['RMTextColHov'];
        $clickCol = empty($options['RMLineCol']) ? "#FFFFFF" : $options['RMLineCol'];
        $clickBkg = empty($options['RMBkgTran']) ? "background: {$options['RMClickBkg']};" : '';
        $borCol = empty($options['RMBorCol']) ? "#3C3C3C" : $options['RMBorCol'];
        $breakpoint = empty($options['RMBreak']) ? "400" : $options['RMBreak'];
        $titleBkg = empty($options['RMTitleBkg']) ? "#43494C" : $options['RMTitleBkg'];
        
        $fontSize = empty($options['RMFontSize']) ? 13 : $options['RMFontSize'];
        $titleSize = empty($options['RMTitleSize']) ? 14 : $options['RMTitleSize'];                        
        $btnSize = empty($options['RMBtnSize']) ? 13 : $options['RMBtnSize'];
        
        $curBkg = empty($options['RMCurBkg']) ? $mainBkg : $options['RMCurBkg'];
        $curCol = empty($options['RMCurCol']) ? $txtCol : $options['RMCurCol'];
        
        /* Added 1.7 */
        $trans = empty( $options['RMTranSpd'] ) ? 1 : $options['RMTranSpd'];
        $align = empty( $options['RMTxtAlign'] ) ? 'left' : $options['RMTxtAlign'];
        $linkPadding = $options['RMTxtAlign'] == 'right' ? '12px 5% 12px 0px' : '12px 0px 12px 5%';
        $titlePadding = $options['RMTxtAlign'] == 'right' ? '20px 5% 20px 0px' : '20px 0px 20px 5%';
        $paddingAlign = $align == 'center' ? 'left' : $align;
                
        $css = "

        <style>

            .RMPushOpen
            {
                width: 100% !important;
                overflow-x: hidden !important;
                height: 100% !important;
            }

            .RMPushSlide
            {
                position: relative;
                left: $width%;
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
                font-size: {$fontSize}px !important;
                max-width: 999px;
                display: none;
            }

            #responsive-menu .appendLink
            {
                right: 0px !important;
                position: absolute !important;
                border: 1px solid $borCol !important;
                padding: 12px 10px !important;
                color: $txtCol !important;
                background: $mainBkg !important;
                height: 20px !important;
                line-height: 20px !important;
            }
            
            #responsive-menu .appendLink:hover
            {
                cursor: pointer;
                background: $mainBkgH !important;
                color: $txtColH !important;
            }

            #responsive-menu .responsive-menu, 
            #responsive-menu div, 
            #responsive-menu .responsive-menu li,
            #responsive-menu
            {
                text-align: $align !important;
            }
                    
            #responsive-menu .RMImage
            {
                vertical-align: middle;
                margin-right: 10px;
            }

            #responsive-menu,
            #responsive-menu input {
                $font
            }      
            
            #responsive-menu #responsive-menu-title			
            {
                width: 95% !important; 
                font-size: {$titleSize}px !important; 
                padding: $titlePadding !important;
                margin-left: 0px !important;
                background: $titleBkg !important;
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

                transition: {$trans}s all;
                -webkit-transition: {$trans}s all;
                -moz-transition: {$trans}s all;
                -o-transition: {$trans}s all;

            }
            
            #responsive-menu .responsive-menu			
            { 
                float: left !important;  
                width: 100% !important; 
                list-style-type: none !important;
                margin: 0px !important;
            }
                        
            #responsive-menu .responsive-menu li.current_page_item a
            {
                background: $curBkg !important;
                color: $curCol !important;
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
                padding: $linkPadding !important;
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
                font-size: {$btnSize}px !important;
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
                display: block !important;
                width: 95% !important;
                padding-left: 5% !important;
                border-top: 1px solid $borCol !important; 
                clear: both !important;
                padding-top: 10px !important;
                padding-bottom: 10px !important;
                height: 40px !important;
                line-height: 40px !important;
            }

            #responsive-menu #responsiveSearchInput
            {
                width: 91% !important;
                padding: 5px 0px 5px 3% !important;
                -webkit-appearance: none !important;
                border-radius: 2px !important;
            }
  
            #responsive-menu .responsive-menu,
            #responsive-menu div,
            #responsive-menu .responsive-menu li
            {
                width: 100% !important;
                float: left !important;
                margin-left: 0px !important;
                padding-left: 0px !important;
            }

            #responsive-menu .responsive-menu li li a
            {
                padding-$paddingAlign: 10% !important;
                width: 90% !important;
                overflow: hidden !important;
            }
 
            #responsive-menu .responsive-menu li li li a
            {
                padding-$paddingAlign: 15% !important;
                width: 85% !important;
                overflow: hidden !important;
            }
            
            #responsive-menu .responsive-menu li li li li
            {
                display: none!important;
            }
            
            #responsive-menu .responsive-menu li a:hover
            {       
                background: $mainBkgH !important;
                color: $txtColH !important;
                list-style-type: none !important;
                text-decoration: none !important;
            }
            
            #click-menu .threeLines
            {
                width: 33px !important;
                height: 33px !important;
                margin: auto !important;
            }

            #click-menu .threeLines .line
            {
                height: 5px !important;
                margin-bottom: 6px !important;
                background: $clickCol !important;
                width: 100% !important;
            }

            @media only screen and ( min-width : 0px ) and ( max-width : {$breakpoint}px ) { 

                #click-menu	
                {
                    display: block;
                }

";

        $css .= $options['RMCss'] ? $options['RMCss'] . " { display: none !important; } " : '';
        $css .= $options['RMDepth'] == 1 ? " #responsive-menu .responsive-menu li li { display: none; } " : '';
        $css .= $options['RMDepth'] == 2 ? " #responsive-menu .responsive-menu li li li { display: none; } " : '';


        $css .= " }";

        $css .= $options['RMAnim'] == 'push' && $options['RMPushCSS'] ? $options['RMPushCSS'] . " { position: relative !important; left: 0px; } " : '';

        $css .= "</style>";

        return $css;
    }

    private static function checkViewPortTag() {

        $metaTags = get_meta_tags(get_bloginfo('url'));

        if ($metaTags['viewport'])
            return $metaTags['viewport'];
    }

    private static function filterInput($input) {

        return stripslashes(strip_tags(trim($input)));
        
    }

}
