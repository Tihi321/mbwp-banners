<?php
/**
 * @package  MBWPBanners
 */
namespace Inc\Modules\Layout;

class DatabaseController
{
    public function getLayoutOptions(){

        $layout_options = array();
        $options = get_option( "mbwp_banners" );

        $layout_class = @$options["custom_layout"]["custom"] ? @$options["custom_layout"]["type"] == "1" ? "mbwp_boxed_layout" : "" : "" ;

        $page_width = isset($options["custom_layout"]["width"]) ? (int)$options["custom_layout"]["width"]:0;
        $bg_color = isset($options["background_color"]) ? $options["background_color"]:"";

        $layout_options["boxed_layout"] = @$options["custom_layout"]["custom"] ? @$options["custom_layout"]["type"] == "1" ? true : false : false ;
        $layout_options["class"] = $layout_class;
        $layout_options["page_width"] = $page_width;
        $layout_options["background_color"] = $bg_color;

        return $layout_options;

    }
}