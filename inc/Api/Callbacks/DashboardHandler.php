<?php 
/**
 * @package  MBWPBanners
 */
namespace Inc\Api\Callbacks;


class DashboardHandler
{

    public function sanitizeNumbers($arg, $min = 0){
		$output = ((int)$arg >= $min)?(int)$arg:0;
		return $output;
	}

		/**
	 * Function that will check if value is a valid HEX color.
	 */
	public function checkColor( $value ) { 
		
		if ( preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) { // if user insert a HEX color with #     
			return true;
		}
		
		return false;
	}

	public function sanitizeBannerStyle($banner_style)
	{

		$output = array();

		$output["width"] = isset( $banner_style["width"] ) ? $this->sanitizeNumbers($banner_style["width"]) : 0;

		$output["height"] = isset( $banner_style["height"] ) ? $this->sanitizeNumbers($banner_style["height"]) : 0;

		$output["padding"] = isset( $banner_style["padding"] ) ? $this->sanitizeNumbers($banner_style["padding"]) : 0;

		$output["units"] = isset( $banner_style["units"] ) ? true : false;

		$output["extra_style"] = isset( $banner_style["extra_style"] ) ? true : false;

		return $output;

	}

	public function sanitizeCustomLayout($custom_layout)
	{
		$output = array();
		
		$output["custom"] = isset( $custom_layout["custom"] ) ? true : false;

		$output["type"] = isset( $custom_layout["type"] ) ? ($custom_layout["type"] == 1 ) ? 1 : 2 : 1;

		$output["width"] = isset( $custom_layout["width"] ) ? $this->sanitizeNumbers($custom_layout["width"], 500) : 0;
		
		return $output;

	}

}