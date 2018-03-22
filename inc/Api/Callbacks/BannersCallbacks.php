<?php 
/**
 * @package  MBWPBanners
 */
namespace Inc\Api\Callbacks;

use Inc\Api\Callbacks\CallbacksHelper;

class BannersCallbacks
{
	
	public $callbacks_helper;

	public function bannersSectionManager()
	{
		echo '';
	}

	function register()
	{

		$this->callbacks_helper = new CallbacksHelper();
		
	}


	public function bannersSanitize( $input )
	{
		$output = get_option('mbwp_banners_list');


		if ( isset($_POST["remove"]) ) {
			unset($output[$_POST["remove"]]);

			return $output;
		}

		if ( count($output) == 0 ) {
			$output[$input['banner_ime']] = $input;

			return $output;
		}

		foreach ($output as $key => $value) {
			if ($input['banner_ime'] === $key) {
				$output[$key] = $input;
			} else {
				$output[$input['banner_ime']] = $input;
			}
		}
		
		return $output;
	}

	public function textField( $args )
	{
		$name = $args['label_for'];
		$option_name = $args['option_name'];
		$required = ($args['required'] == "yes")?"required":"";
		$value = '';

		if ( isset($_POST["edit_post"]) ) {
			$input = get_option( $option_name );
			$value = $input[$_POST["edit_post"]][$name];
		}

		echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" ' . $required . '>';
	}

	public function checkboxField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$checked = false;

		if ( isset($_POST["edit_post"]) ) {
			$checkbox = get_option( $option_name );
			$checked = isset($checkbox[$_POST["edit_post"]][$name]) ?: false;
		}

		echo $this->callbacks_helper->checkboxToggleField($classes, $checked, $option_name, $name );

	}



	public function radioButtons($args){


		$name = $args['label_for'];
		$radio_number = (int)$args['radio_repeat'];
		$option_name = $args['option_name'];
		$type = $args['radio_type'];
		$radio_value = 1;

		if ( isset($_POST["edit_post"]) ) {
			$options = get_option( $option_name );
			$radio_value = (int)$options[$_POST["edit_post"]][$name];
		}


			$output = '<div class="radio-wrapper">';

			for ($i=1; $i <= $radio_number; $i++) {

				$label = $this->radioType($i, $type);

				$output .= $this->callbacks_helper->radioField($i, $radio_value, $option_name, $name, $type, $label );
			}

			$output .= '</div>';

			echo $output;

	 }
	 
	private function radioType($num, $type){

		if($type == "priority") return $num;

		switch ($num) {
			case 1:
				return "Top";
				break;
			case 2:
				return "Left";
				break;
			case 3:
				return "Right";
				break;
			
			default:

				break;
		}
	}



	public function cptTable($options_list){

		echo '<table class="cpt-table"><tr><th class="name">Name</th><th class="note">Note</th><th class="text-center small">Priority</th><th class="text-center small">Active</th><th class="text-center btns">Options</th></tr>';

		foreach ($options_list as $option) {
			$active = isset($option['activate']) ? "yes" : "no";

			echo "<tr><td class='name'>{$option['banner_ime']}</td><td class='note'>{$option['napomena']}</td><td class=\"text-center small\">{$option['radio_priority']}</td><td class=\"text-center small {$active}\">{$active}</td><td class=\"text-center btns\">";

			echo '<form method="post" action="" class="inline-block">';
			echo '<input type="hidden" name="edit_post" value="' . $option['banner_ime'] . '">';
			submit_button( 'Edit', 'primary small', 'submit', false);
			echo '</form> ';

			echo '<form method="post" action="options.php" class="inline-block">';
			settings_fields( 'mbwp_banners_list_settings' );
			echo '<input type="hidden" name="remove" value="' . $option['banner_ime'] . '">';
			submit_button( 'Remove', 'delete small', 'submit', false, array(
				'onclick' => 'return confirm("Are you sure you want to delete this Custom Post Type? The data associated with it will not be deleted.");'
			));
			echo '</form></td></tr>';
		}

		echo '</table>';
	}


}