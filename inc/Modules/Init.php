<?php
/**
 * @package  MBWPBanners
 */
namespace Inc\Modules;

class Init
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public function getServices() 
	{
		return [
			Layout\LayoutController::class,
			Banners\BannersController::class,
			Base\ModulesController::class,
		];
	}

	/**
	 * Loop through the classes, initialize them, 
	 * and call the register() method if it exists
	 * @return none
	 */
	public function register() 
	{
		
		foreach ( $this->getServices() as $class ) {
			$service = $this->instantiate( $class );
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}

	/**
	 * Initialize the class
	 * @param  class $class    class from the services array
	 * @return class instance  new instance of the class
	 */
	private function instantiate( $class )
	{
		$service = new $class();

		return $service;
	}
}