<?php 
/**
 * @package  MBWPBanners
 */
namespace Inc\Pages\Settings;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\BannersCallbacks;
use Inc\Api\Callbacks\TemplatesController;

/**
* 
*/
class BannersController extends BaseController
{
	public $settings;

	public $callbacks;

	public $banners_callback;

	public $subpages = array();

	public $custom_post_types = array();

	public function register()
	{

		$this->settings = new SettingsApi();

		$this->callbacks = new TemplatesController();

		$this->banners_callback = new BannersCallbacks();
		$this->banners_callback->register();

		$this->setSubpages();

		$this->setSettings();

		$this->setSections();

		$this->setFields();

		$this->settings->addSubPages( $this->subpages )->register();
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'mbwp_banners', 
				'page_title' => '', 
				'menu_title' => 'Add/Edit Banner', 
				'capability' => 'manage_options', 
				'menu_slug' => 'mbwp_banners_list_page', 
				'callback' => array( $this->callbacks, 'bannersTemplate' )
			)
		);
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'mbwp_banners_list_settings',
				'option_name' => 'mbwp_banners_list',
				'callback' => array( $this->banners_callback, 'bannersSanitize' )
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'mbwp_banners_list_page_index',
				'title' => '',
				'callback' => array( $this->banners_callback, 'bannersSectionManager' ),
				'page' => 'mbwp_banners_list_page'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
			array(
				'id' => 'activate',
				'title' => 'Activate',
				'callback' => array( $this->banners_callback, 'checkboxField' ),
				'page' => 'mbwp_banners_list_page',
				'section' => 'mbwp_banners_list_page_index',
				'args' => array(
					'option_name' => 'mbwp_banners_list',
					'label_for' => 'activate',
					'class' => 'ui-toggle'
				)
			),

			array(
				'id' => 'only_image',
				'title' => 'Show Image Only',
				'callback' => array( $this->banners_callback, 'checkboxField' ),
				'page' => 'mbwp_banners_list_page',
				'section' => 'mbwp_banners_list_page_index',
				'args' => array(
					'option_name' => 'mbwp_banners_list',
					'label_for' => 'only_image',
					'class' => 'ui-toggle'
				)
			),

			array(
				'id' => 'responsive',
				'title' => 'Responsive',
				'callback' => array( $this->banners_callback, 'checkboxField' ),
				'page' => 'mbwp_banners_list_page',
				'section' => 'mbwp_banners_list_page_index',
				'args' => array(
					'option_name' => 'mbwp_banners_list',
					'label_for' => 'responsive',
					'class' => 'ui-toggle'
				)
			),

			array(
				'id' => 'banner_ime',
				'title' => 'Name',
				'callback' => array( $this->banners_callback, 'textField' ),
				'page' => 'mbwp_banners_list_page',
				'section' => 'mbwp_banners_list_page_index',
				'args' => array(
					'option_name' => 'mbwp_banners_list',
					'label_for' => 'banner_ime',
					'placeholder' => 'name',
					'required' => 'yes',
				)
			),

			array(
				'id' => 'banner_type',
				'title' => 'Type',
				'callback' => array( $this->banners_callback, 'radioButtons' ),
				'page' => 'mbwp_banners_list_page',
				'section' => 'mbwp_banners_list_page_index',
				'args' => array(
					'option_name' => 'mbwp_banners_list',
					'label_for' => 'banner_type',
					'radio_repeat' => '3',
					'radio_type' => "banners"
				)
			),

			array(
				'id' => 'radio_priority',
				'title' => 'Priority',
				'callback' => array( $this->banners_callback, 'radioButtons' ),
				'page' => 'mbwp_banners_list_page',
				'section' => 'mbwp_banners_list_page_index',
				'args' => array(
					'option_name' => 'mbwp_banners_list',
					'label_for' => 'radio_priority',
					'radio_repeat' => '5',
					'radio_type' => "priority"
				)
			),

			array(
				'id' => 'banner_link',
				'title' => 'Banner Link',
				'callback' => array( $this->banners_callback, 'textField' ),
				'page' => 'mbwp_banners_list_page',
				'section' => 'mbwp_banners_list_page_index',
				'args' => array(
					'option_name' => 'mbwp_banners_list',
					'label_for' => 'banner_link',
					'placeholder' => 'link to iframe',
					'required' => 'no',
				)
			),

			array(
				'id' => 'image_link',
				'title' => 'Image Link',
				'callback' => array( $this->banners_callback, 'textField' ),
				'page' => 'mbwp_banners_list_page',
				'section' => 'mbwp_banners_list_page_index',
				'args' => array(
					'option_name' => 'mbwp_banners_list',
					'label_for' => 'image_link',
					'placeholder' => 'link to backup image',
					'required' => 'no',
				)
			),

			array(
				'id' => 'out_link',
				'title' => 'Ad Link',
				'callback' => array( $this->banners_callback, 'textField' ),
				'page' => 'mbwp_banners_list_page',
				'section' => 'mbwp_banners_list_page_index',
				'args' => array(
					'option_name' => 'mbwp_banners_list',
					'label_for' => 'out_link',
					'placeholder' => 'external link to an ad',
					'required' => 'no',
				)
			),

			array(
				'id' => 'extra_class',
				'title' => 'Extra Classes',
				'callback' => array( $this->banners_callback, 'textField' ),
				'page' => 'mbwp_banners_list_page',
				'section' => 'mbwp_banners_list_page_index',
				'args' => array(
					'option_name' => 'mbwp_banners_list',
					'label_for' => 'extra_class',
					'placeholder' => 'add extra classes to iframe',
					'required' => 'no',
				)
			),
			
			array(
				'id' => 'napomena',
				'title' => 'Note',
				'callback' => array( $this->banners_callback, 'textField' ),
				'page' => 'mbwp_banners_list_page',
				'section' => 'mbwp_banners_list_page_index',
				'args' => array(
					'option_name' => 'mbwp_banners_list',
					'label_for' => 'napomena',
					'placeholder' => 'note', 
					'required' => 'no',
				)
			),
		);

		$this->settings->setFields( $args );
	}

}