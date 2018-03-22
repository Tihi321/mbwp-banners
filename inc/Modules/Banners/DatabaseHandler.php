<?php
/**
 * @package  MBWPBanners
 */
namespace Inc\Modules\Banners;


class DatabaseHandler
{

    function getTopPositionStyle($page_width, $width, $left_banners, $right_banners ){

        $output = "";

        if( $left_banners == 0 && $right_banners == 0 ){

            $output .= ($page_width != "") ? "margin:0 auto;max-width:{$page_width}px;": "";

        } elseif( $left_banners == 0){

            $output = ($page_width != "") ? "margin:0 auto;max-width:{$page_width}px;": "margin-left:unset;max-width:calc(100% - " . ((int)$width)  . "px);";

        } elseif( $right_banners == 0){

            $output = ($page_width != "") ? "margin:0 auto;max-width:{$page_width}px;": "margin-right:unset;max-width:calc(100% - " . ((int)$width)  . "px);";

        } else {
            $output = ($page_width != "") ? "margin:0 auto;max-width:{$page_width}px;": "max-width:calc(100% - " . ((int)$width*2)  . "px);";
        }

        return $output;

    }
    function getSidePositionStyle($page_width, $position ){

        $output = "";

        switch ($position) {
            case 'left':
                $output = ($page_width != "") ? "right:50%;width:" . ((int)$page_width/2) . "px;": "width:100%;right:0;";
                break;
            case 'right':
                $output = ($page_width != "") ? "left:50%;width:" . ((int)$page_width/2) . "px;": "width:100%;left:0;";
                break;
            default:
                break;
        }

        return $output;

    }

    function getBannerStyle($banner_style_input, $default_style = false){

        if($default_style == false){
            $default_style = $banner_style_input;
        }

        $banner_style = array(
        );

        $checkbox = (@$banner_style_input['units']) ? $banner_style_input['units'] : false;

        $width = (@$banner_style_input['width']) ? ($checkbox) ? "width:" . $banner_style_input['width'] . "%;" :  "width:" . $banner_style_input['width'] . "px;" : "width:" . $default_style["width"] . "px;";

        $height = (@$banner_style_input['height']) ?  "height:" . $banner_style_input['height'] . "px;" : "height:" . $default_style["height"] . "px;";
        

        $banner_style["width"] = (@$banner_style_input['width']) ? $banner_style_input['width'] : $default_style["width"];
        $banner_style["child_style"] = $width . $height;


        return $banner_style;

    }

}