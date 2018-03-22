<?php
/**
 * @package  MBWPBanners
 */
namespace Inc\Modules\Layout;

use Inc\Modules\Layout\DatabaseController;

class LayoutBuilder extends DatabaseController
{

    private $layout_options = array();

	function register() {

        $this->layout_options = $this->getLayoutOptions();

    }

    function addLayoutClass( $class = '' ) {
        
        if( $this->layout_options['class'] != "" && $this->layout_options['page_width'] > 499 ) {
            add_filter( 'body_class',array($this, "layoutClass") );
            add_action('wp_head',array($this,'hookCss' ) );
        }
    }

    function layoutClass($classes){

            $classes[] = $this->layout_options['class'];
            return $classes;

    }

    function hookCss() {
        $output = "<style>";
        $output .= $this->layout_options['background_color'] != "" ? "body{background-color:{$this->layout_options['background_color']};}" : "";
        echo $output;
    }

    function getWrapperCode(){

        $output  = "<div class='mbwp_wrapper' style='position:relative;max-width:{$this->layout_options['page_width']}px;margin:0 auto;'>";

        $code_output['prepend'] = $output;
        $code_output['append'] = "</div>";

        return $code_output;
        
    }

    function isBoxedLayout(){

        return $this->layout_options['boxed_layout'];

    }

}