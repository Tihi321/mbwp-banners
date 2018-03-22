<?php
/**
 * @package  MBWPBanners
 */
namespace Inc\Modules\Banners;


class BannersHandler
{

    function getPriorityBanner($banners){

        $count = count($banners);
        $coefficient_sum = 0;
        $coefficient_sum_check = 0;
        
        for ($i=0; $i < $count; $i++) {
                $coefficient[$i] = 1;

            if( @$banners[$i]['radio_priority'] && ($banners[$i]['radio_priority'] > 1) ){
                $coefficient[$i] += $banners[$i]['radio_priority'];
            }
            $coefficient_sum += $coefficient[$i];
        }

        $random_banner_number = rand(1,$coefficient_sum);

        for ($i=0; $i < $count; $i++) {
                $coefficient_sum_check += 1;

            if( @$banners[$i]['radio_priority'] && ($banners[$i]['radio_priority'] > 1) ){
                $coefficient_sum_check += $banners[$i]['radio_priority'];
            }

            if( $random_banner_number <= $coefficient_sum_check ){
                return $banners[$i];
            }
        }
        
    }

}