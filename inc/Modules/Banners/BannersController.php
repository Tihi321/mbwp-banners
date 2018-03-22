<?php
/**
 * @package  MBWPBanners
 */
namespace Inc\Modules\Banners;

use Inc\Modules\Banners\BannerBuilder;
use Inc\Modules\Base\ModulesController;
use Inc\Modules\Banners\DatabaseController;


class BannersController
{


    function register()
    {
        $banner_options = array();
        $base_helper = new DatabaseController();

        $base_helper->register();

        $banner_options["top"] = $base_helper->getBannersOptions("top");
        $banner_options["left"] = $base_helper->getBannersOptions("left");
        $banner_options["right"] =  $base_helper->getBannersOptions("right");


        $elements_code = $this->getTheCode($banner_options);

        ModulesController::$code['prepend'] .= $elements_code;

        
    }
    
    function getTheCode($banner_options)
    {
        $banner_builder = new BannerBuilder();
        
        $element_code = "";
        foreach ($banner_options as $option) {
           $element_code .= $banner_builder->generateElements($option);
        }
        
        return $element_code;

    }

    
}