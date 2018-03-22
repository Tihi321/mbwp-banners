<?php
/**
 * @package  MBWPBanners
 */
namespace Inc\Modules\Base;


class ModulesController 
{

    public static $code = array(
        "prepend" => "",
        "append" => "",
    );

    function register(){

        if($GLOBALS['pagenow'] !== 'wp-login.php' && !is_admin()) {

            $this->injectbodyElements();

        }
    }

    function injectbodyElements(){
        ob_start();

        add_action('shutdown', function() {
            $final = '';
            
            // We'll need to get the number of ob levels we're in, so that we can iterate over each, collecting
            // that buffer's output into the final output.
            $levels = ob_get_level();

            for ($i = 0; $i < $levels; $i++) {
                $final .= ob_get_clean();
            }
            
            // Apply any filters to the final output
            echo apply_filters('final_output', $final);
        }, 0);

        add_filter('final_output', function($output) {

            $output = preg_replace("/(\<body.*\>)/", "$1".self::$code['prepend'], $output);
            $output = preg_replace("/(\<.*.body\>)/", "$1".self::$code['append'], $output);
            return $output;
        });
    }

}