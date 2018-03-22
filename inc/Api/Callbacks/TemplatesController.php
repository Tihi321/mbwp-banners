<?php 
/**
 * @package  MBWPBanners
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class TemplatesController extends BaseController
{
	public function adminDashboard()
	{
		return require_once( "$this->plugin_path/templates/dashboard.php" );
	}

	public function bannersTemplate()
	{
		return require_once( "$this->plugin_path/templates/banners.php" );
	}

}