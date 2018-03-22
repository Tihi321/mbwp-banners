<?php
/**
 * @package  MBWPBanners
 */
namespace Inc\Modules\Banners;

use Inc\Modules\Banners\BannersHandler;

class BannerBuilder extends BannersHandler
{


    function generateElements($banner_options){

        $output = "";
        $banners_list = $banner_options['banners'];
        if(!$banners_list) return "";

        $wrapper_id = $banner_options['element_prefix'] . "_wrapper";
        $classes = (@$banner_options['classes'])?$banner_options['classes']:"";

        $output .= "<div id='{$wrapper_id}' class='mbwp_elements {$wrapper_id} {$classes}'";
        $output .= $banner_options['parent_style'];

        
        $output .= ($banner_options['cache'])?" wp-cache":"";
        $output .= '>';
        if($banner_options['cache']){

            for ($i = 0; $i < count($banners_list); $i++) {
                $banner = $banners_list[$i];
                $output .= $this->generateBannerCode($banner_options, $banners_list[$i], false);
            }

        }else {

            if(count($banners_list) > 1){
                shuffle($banners_list);
                $banner = $this->getPriorityBanner($banners_list);
            }else{
                $banner = $banners_list[0];
            }

            $output .= $this->generateBannerCode($banner_options, $banner);
        }

        $output .= '</div>';

        return $output;

    }


    function generateBannerCode($banner_options, $banner, $single = true){

        $banner_options['default_image'] = $banner_options['default_image'];
        $id = ($single)?$banner_options['element_prefix']."_1":$banner['id'];

        $only_image = (@$banner['only_image'])?true:false;
        $responsive = (@$banner['responsive'])?true:false;

        $extra_style = (@$banner_options['extra_style_class'])?$banner_options['extra_style_class']:"";
        
        $banner_link = ($banner['banner_link'] != "")?esc_attr($banner['banner_link']):"";
        
        
        if($banner_link == ""){
            $only_image = true;
        }

        
        $image_link = ($banner['image_link'] != "")? esc_attr($banner['image_link']) : $banner_options['default_image'];
        $ad_link = ($banner['out_link'] != "")? esc_attr($banner['out_link']) : $banner_options['default_link'];
        
        if( $image_link == $banner_options['default_image']){
            $ad_link = $banner_options['default_link'];
        }
        
        $extra_class = (@$banner_options['extra_class'] != "")? esc_attr($banner_options['extra_class']) : false;

        $output = "";

            $output .= "<div id='{$id}' class='mbwp-inner-elements";
            $output .= ($banner_options['cache'])?" hidden-element":"";
            $output .= ($responsive != false)?"":" not-responsive";
            $output .= "'";
            $output .= (@$banner_options['page_inner_margin'])?$banner_options['page_inner_margin']:"";
            $output .= ($banner_options['cache'])?" data-priority='{$banner['radio_priority']}' ":"";
            $output .= ">";
            if ($only_image) {
                $output .= '<a href=' . $ad_link .' target="_blank"><img';
                $output .= ($extra_style != "") ? " class='{$extra_style}' " :" " ;
                $output .= 'style="' . $banner_options['child_style'] . '" src="' . $image_link . '"></a>';
            } else {
                $output .= "<iframe  src='' style='{$banner_options['child_style']}'  data-src=";
                $output .= '"' . $banner_link . '"';
                $output .= ' class="mbwp-iframe';
                $output .= ($extra_class != false)?" " . $extra_class. " ":" ";
                $output .= $extra_style . '"';
                $output .= '></iframe>';
                $output .= '<a class="banner-backup-image hidden" href=' . $ad_link .' target="_blank">';
                $output .= '<img';
                $output .= ($extra_style != "") ? " class='{$extra_style}' " :" " ;
                $output .= 'style="' . $banner_options['child_style'] . '" src="' . $image_link . '"></a>';
            }
            $output .= '</div>';

        return $output;

    }

}