<?php

class BaseModel {
    
    static function Filter( $input ) {

        return stripslashes( strip_tags( trim( $input ) ) );
        
    }
    
    /* Added 1.9 *
     * Function to minify outputted JavaScript and CSS Files
     * Parts taken from
     * http://castlesblog.com/2010/august/14/php-javascript-css-minification
     * @param string $input
     * @param string $type [css, js]
     */
    
    static function Minify( $input ) {

        /* remove comments */
        
        $output = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $input);
        
        /* remove tabs, spaces, newlines, etc. */
        
        $output = str_replace(array("\r\n","\r","\n","\t",'  ','    ','     '), '', $output);
        
        /* remove other spaces before/after ; */
        
        $output = preg_replace(array('(( )+{)','({( )+)'), '{', $output);
        $output = preg_replace(array('(( )+})','(}( )+)','(;( )*})'), '}', $output);
        $output = preg_replace(array('(;( )+)','(( )+;)'), ';', $output);

        return $output;
        
    }
    
}