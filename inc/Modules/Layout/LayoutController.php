<?php
/**
 * @package  MBWPBanners
 */
namespace Inc\Modules\Layout;

use Inc\Modules\Layout\LayoutBuilder;
use Inc\Modules\Base\ModulesController;

class LayoutController
{
    private $layout_builder;

    function register(){

        $this->layout_builder = new LayoutBuilder();
        $this->layout_builder->register();

        if($GLOBALS['pagenow'] !== 'wp-login.php' && !is_admin() && $this->layout_builder->isBoxedLayout()) {
            $this->layout_builder->addLayoutClass();
            $this->setWrapperCode();
        }


    }

    private function setWrapperCode(){

        $code = $this->layout_builder->getWrapperCode();

        ModulesController::$code['prepend'] .= $code['prepend'];
        ModulesController::$code['append'] .= $code['append'] ;
    }


}