<?php 
/**
 * @package  MBWPBanners
 */
namespace Inc\Pages\Settings;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\DashboardHandler;
use Inc\Api\Callbacks\DashboardCallbacks;
use Inc\Api\Callbacks\TemplatesController;

class Dashboard extends BaseController
{
	public $settings;

	public $callbacks;

	public $callbacks_mngr;

	public $callbacks_hand;

	public $pages = array();

	public function register() 
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new TemplatesController();

		$this->callbacks_mngr = new DashboardCallbacks();
		$this->callbacks_mngr->register();

		$this->callbacks_hand = new DashboardHandler();


		$this->setPages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->register();
	}

	public function setPages() 
	{
		$this->pages = array(
			array(
				'page_title' => 'MBWP Banners', 
				'menu_title' => 'MBWP', 
				'capability' => 'manage_options', 
				'menu_slug' => 'mbwp_banners', 
				'callback' => array( $this->callbacks, 'adminDashboard' ), 
				'icon_url' => 'dashicons-index-card', 
				'position' => 110
			)
		);
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'mbwp_banners_settings',
				'option_name' => 'mbwp_banners',
				'callback' => array( $this, 'sanitizeValues' )
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'alecaddd_admin_index',
				'title' => '',
				'callback' => array( $this->callbacks_mngr, 'adminSectionManager' ),
				'page' => 'mbwp_banners'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array();

		$args[] = array(
			'id' => "wp_cache",
			'title' => "WP Cache",
			'callback' => array( $this->callbacks_mngr, 'checkboxCacheField' ),
			'page' => 'mbwp_banners',
			'section' => 'alecaddd_admin_index',
			'args' => array(
				'option_name' => 'mbwp_banners',
				'label_for' => "wp_cache",
				'class' => 'ui-toggle',
				"repeat" => "3"
			)
		);

		$args[] = array(
			'id' => "custom_layout",
			'title' => "Custom Layout",
			'callback' => array( $this->callbacks_mngr, 'customLayout' ),
			'page' => 'mbwp_banners',
			'section' => 'alecaddd_admin_index',
			'args' => array(
				'option_name' => 'mbwp_banners',
				'label_for' =>"custom_layout",
				'class' => 'ui-toggle',
				"radio_repeat" => "2",
			)
		);

		$args[] = array(
			'id' => "background_color",
			'title' => "Background Color",
			'callback' => array( $this->callbacks_mngr, 'colorField' ),
			'page' => 'mbwp_banners',
			'section' => 'alecaddd_admin_index',
			'args' => array(
				'option_name' => 'mbwp_banners',
				'label_for' => "background_color",
			)
		);
		
		$args[] = array(
			'id' => "top_banner_style",
			'title' => "Top Banner Style",
			'callback' => array( $this->callbacks_mngr, 'bannerStyle' ),
			'page' => 'mbwp_banners',
			'section' => 'alecaddd_admin_index',
			'args' => array(
				'option_name' => 'mbwp_banners',
				'label_for' =>"top_banner_style",
				'class' => 'ui-toggle',
				'type' => 'top',
				)
			);
			
		$args[] = array(
			'id' => "top_banner_bg",
			'title' => "Top Banner Color",
			'callback' => array( $this->callbacks_mngr, 'colorField' ),
			'page' => 'mbwp_banners',
			'section' => 'alecaddd_admin_index',
			'args' => array(
				'option_name' => 'mbwp_banners',
				'label_for' => "top_banner_bg",
			)
		);
		
		$args[] = array(
			'id' => "side_banner_style",
			'title' => "Side Banner Style",
			'callback' => array( $this->callbacks_mngr, 'bannerStyle' ),
			'page' => 'mbwp_banners',
			'section' => 'alecaddd_admin_index',
			'args' => array(
				'option_name' => 'mbwp_banners',
				'label_for' =>"side_banner_style",
				'class' => 'ui-toggle',
				'type' => 'side',
				)
			);
			
		$args[] = array(
			'id' => "side_banner_bg",
			'title' => "Side Banner Color",
			'callback' => array( $this->callbacks_mngr, 'colorField' ),
			'page' => 'mbwp_banners',
			'section' => 'alecaddd_admin_index',
			'args' => array(
				'option_name' => 'mbwp_banners',
				'label_for' => "side_banner_bg",
			)
		);

		$this->settings->setFields( $args );
	}


	public function sanitizeValues( $input )
	{
		$output = array();

		$output["page_width"] = isset( $input["page_width"] ) ? $this->callbacks_hand->sanitizeNumbers($input["page_width"], 500) : 0;

		for ($i=1; $i <= 3; $i++) { 
			$output["wp_cache"][$i] = isset( $input["wp_cache"][$i] ) ? true : false;
		}

		$output["top_banner_style"] = isset( $input["top_banner_style"] ) ? $this->callbacks_hand->sanitizeBannerStyle($input['top_banner_style']) : array();
		$output["side_banner_style"] = isset( $input["side_banner_style"] ) ? $this->callbacks_hand->sanitizeBannerStyle($input['side_banner_style']) : array();


		$output["background_color"] = isset( $input["background_color"] ) ? $this->callbacks_hand->checkColor($input["background_color"])?$input["background_color"]:"" : "";

		$output["top_banner_bg"] = isset( $input["top_banner_bg"] ) ? $this->callbacks_hand->checkColor($input["top_banner_bg"])?$input["top_banner_bg"]:"" : "";

		$output["side_banner_bg"] = isset( $input["side_banner_bg"] ) ? $this->callbacks_hand->checkColor($input["side_banner_bg"])?$input["side_banner_bg"]:"" : "";

		$output["custom_layout"] = $this->callbacks_hand->sanitizeCustomLayout($input['custom_layout']);



		return $output;
	}


}