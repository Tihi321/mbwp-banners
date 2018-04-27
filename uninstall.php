<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package  MBWPBanners
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// Access the database via SQL
global $wpdb;
$wpdb->query( "DELETE FROM wp_options WHERE option_name = 'mbwp_banners'" );
$wpdb->query( "DELETE FROM wp_options WHERE option_name = 'mbwp_banners_cpt'" );