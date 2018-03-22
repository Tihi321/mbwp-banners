<?php
/**
 * @package  MBWPBanners
 */
namespace Inc\Base;

class Activate
{
	public static function activate() {
		flush_rewrite_rules();

		$default = array();

		if ( ! get_option( 'mbwp_banners' ) ) {
			update_option( 'mbwp_banners', $default );
		}

		if ( ! get_option( 'mbwp_banners_list' ) ) {
			update_option( 'mbwp_banners_list', $default );
		}
	}
}