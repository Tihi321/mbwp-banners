<?php
/**
 * @package  MBWPBanners
 */
namespace Inc\Modules\Banners;


use Inc\Modules\Banners\DatabaseHelper;
use Inc\Modules\Banners\DatabaseHandler;

class DatabaseController extends DatabaseHelper
{

    public $top_id_prefix = "mbwp_top_element";
    public $left_id_prefix = "mbwp_left_element";
    public $right_id_prefix = "mbwp_right_element";

    public $base_handler, $options, $global_options;


    public function register(){
        
        $this->base_handler = new DatabaseHandler();
        $this->options = get_option( "mbwp_banners_list" );
        $this->global_options = get_option( "mbwp_banners" );

    }


    public function getBannersOptions($type = "top"){

        $top_banners = $left_banners = $right_banners = $output = array();

        $top_banner_default_style = array(
            "height" => "250",
            "width" =>  "100",
            "margin" => "0"
        );

        $side_banner_default_style = array(
            "height" => "750",
            "width" =>  "300",
            "margin" => "0"
        );

        $default_top_image = $this->plugin_url . "assets/photo/adblock/adblock_970.png";
        $default_side_image = $this->plugin_url . "assets/photo/adblock/adblock_300.png";

        $output["default_link"] = "https://www.facebook.com/Klinika.hr/";


        $page_width = @$this->global_options["custom_layout"]["custom"] ? (@$this->global_options["custom_layout"]["width"])?$this->global_options["custom_layout"]["width"]:"" : "";
        
        $top_banner_style = (@$this->global_options['top_banner_style']) ? $this->base_handler->getBannerStyle($this->global_options['top_banner_style'], $top_banner_default_style) : $this->base_handler->getBannerStyle($top_banner_default_style);

        $top_padding_style = @$this->global_options['top_banner_style']["padding"] ? "padding:" . $this->global_options['top_banner_style']["padding"] . "px;" : "" ;
       
        $top_banner_bg = @$this->global_options['top_banner_bg'] ? "background-color:" . $this->global_options['top_banner_bg'] . ";" : "" ;

        $side_banner_style = (@$this->global_options['side_banner_style']) ? $this->base_handler->getBannerStyle($this->global_options['side_banner_style'], $side_banner_default_style) : $this->base_handler->getBannerStyle($side_banner_default_style);

        $side_banner_bg = @$this->global_options['side_banner_bg'] ? "background-color:" . $this->global_options['side_banner_bg'] . ";" : "" ;
        
        $extra_style = @$this->global_options['side_banner_style']["extra_style"] ? true: false;
        
        $i = $j = $k = 0;
        foreach ($this->options as $key => $value) {
            switch ($this->options[$key]["banner_type"]) {
                case '1':
                    if(!isset($this->options[$key]['activate'])) break;
                    $i++;
                    $this->options[$key]['id'] = $this->top_id_prefix."_".$i;
                    $top_banners[] = $this->options[$key];
                    break;
                case '2':
                    if(!isset($this->options[$key]['activate'])) break;
                    $j++;
                    $this->options[$key]['id'] = $this->left_id_prefix."_".$i;
                    $left_banners[] = $this->options[$key];
                    break;
                case '3':
                    if(!isset($this->options[$key]['activate'])) break;
                    $k++;
                    $this->options[$key]['id'] = $this->right_id_prefix."_".$i;
                    $right_banners[] = $this->options[$key];
                    break;      
                default:
                    break;
            }
        }
        

        switch ($type) {
            case 'top':
                $output["banners"] = $top_banners;
                $output["cache"] = (@$this->global_options['wp_cache']["1"]?($this->global_options['wp_cache']["1"]?true:false):false);
                $output["default_image"] = $default_top_image;
                $output["parent_style"] = $this->getTopParentStyle($page_width, $side_banner_style["width"], count($left_banners), count($right_banners), $top_banner_bg, $top_padding_style);
                $output["element_prefix"] = $this->top_id_prefix;
                $output["child_style"] = $top_banner_style["child_style"];
                $output["classes"] = ($page_width == "") ? "custom-off" : "";
                break;
            case 'left':
                $output["banners"] = $left_banners;
                $output["cache"] = (@$this->global_options['wp_cache']["2"]?($this->global_options['wp_cache']["2"]?true:false):false);
                $output["default_image"] = $default_side_image;
                $output["parent_style"] = $this->getSideParentStyle($page_width, "left");
                $output["page_inner_margin"] = $this->getInnerElementsStyle($page_width, $side_banner_style["width"], "left", $side_banner_bg );
                $output["element_prefix"] = $this->left_id_prefix;
                $output["child_style"] = $side_banner_style["child_style"] . $side_banner_bg;
                $output["extra_style_class"] = ($extra_style)?"mbwp-extra-left":"";
                break;
            case 'right':
                $output["banners"] = $right_banners;
                $output["cache"] = (@$this->global_options['wp_cache']["3"]?($this->global_options['wp_cache']["3"]?true:false):false);
                $output["default_image"] = $default_side_image;
                $output["parent_style"] = $this->getSideParentStyle($page_width, "right");
                $output["page_inner_margin"] = $this->getInnerElementsStyle($page_width, $side_banner_style["width"], "right", $side_banner_bg );
                $output["element_prefix"] = $this->right_id_prefix;
                $output["child_style"] = $side_banner_style["child_style"];
                $output["extra_style_class"] = ($extra_style)?"mbwp-extra-right":"";
                break;            
            default:
                break;
        }

        return $output;

    }

    function getInnerElementsStyle($page_width, $banner_width, $side, $bg){

        if($page_width == "" && $bg == "") return "";

        $output = " style='";
        $output .= ($page_width != "")?"margin-{$side}:-{$banner_width}px;":"";
        $output .= ($bg != "" ) ? $bg :"";
        $output .="'";

        return $output;

    }

    function getTopParentStyle($page_width, $side_banner_width, $left_banners, $right_banners, $top_banner_bg, $top_padding_style){

        $output = "";


        $position_style = $this->base_handler->getTopPositionStyle($page_width, $side_banner_width, $left_banners, $right_banners);
        if($position_style == "") return $output;
        
        $output .= " style='";
        $output .= $position_style . $top_banner_bg . $top_padding_style;
        $output .= "'";

        return $output;

    }

    function getSideParentStyle($page_width, $side){

        $output = "";

        $position_style = $this->base_handler->getSidePositionStyle($page_width, $side);
        if($position_style == "") return $output;
        
        $output .= " style='";
        $output .= $position_style;
        $output .= "'";

        return $output;

    }

    function ddOnFront($output){

        if($GLOBALS['pagenow'] !== 'wp-login.php' && !is_admin()) {
            dd($output);
        }
    }
}