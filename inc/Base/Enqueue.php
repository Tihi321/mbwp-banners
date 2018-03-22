<?php 
/**
 * @package  MBWPBanners
 */
namespace Inc\Base;

use Inc\Base\BaseController;

/**
* 
*/
class Enqueue extends BaseController
{
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueueAdmin' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueueFront' ) );
	}
	
	function enqueueAdmin() {
		

		wp_enqueue_style( 'mbwp-admin-style', $this->plugin_url . 'assets/admin/style.css' );
		wp_enqueue_script( 'mbwp-admin-script', $this->plugin_url . 'assets/admin/script.js', array('jquery','wp-color-picker' ), false, true );
	}

	function enqueueFront() {
		

		wp_enqueue_style( 'mbwp-style', $this->plugin_url . 'assets/front/style.css' );
		wp_enqueue_script( 'mbwp-script', $this->plugin_url . 'assets/front/script.js', array('jquery' ), false, true );
	}
}