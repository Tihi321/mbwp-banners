<?php 
/**
 * @package  MBWPBanners
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;
use Inc\Api\Callbacks\CallbacksHelper;

class DashboardCallbacks extends BaseController
{
	public $callbacks_helper;

	public function adminSectionManager()
	{
		echo '';
	}

	function register()
	{

		$this->callbacks_helper = new CallbacksHelper();
		
	}



	public function bannerStyle( $args )
	{
		$name = $args['label_for'];
		$option_name = $args['option_name'];
		$classes = $args['class'];
		$type = $args['type'];
		$options = get_option( $option_name );

		
		$output = "";
		
		
		if($type == 'top'){
			
			$subfield_name = "units";
			$checked = isset($options[$name][$subfield_name]) ? ($options[$name][$subfield_name] ? true : false) : false;

			$output .= $this->callbacks_helper->checkboxToggleField($classes, $checked, $option_name, $name, $subfield_name );
			
		}else {
			
			$subfield_name = "extra_style";
			$checked = isset($options[$name][$subfield_name]) ? ($options[$name][$subfield_name] ? true : false) : false;
			
			$output .= $this->callbacks_helper->checkboxToggleField($classes, $checked, $option_name, $name, $subfield_name );
		}

		$output .= "<div class='iframe-size-wrapper'>";
		$value_width = (isset($options[$name]["width"]) && $options[$name]["width"] != 0) ?$options[$name]["width"]: "";
		$value_height = (isset($options[$name]["height"]) && $options[$name]["height"] != 0) ?$options[$name]["height"]: "";
		
		$output .= $this->callbacks_helper->numbersField($value_width, $option_name, $name, "width" );
		$output .= $this->callbacks_helper->numbersField($value_height, $option_name, $name, "height" );
		
		
		if($type == 'top'){
			
			$value_padding = (isset($options[$name]["padding"]) && $options[$name]["padding"] != 0) ?$options[$name]["padding"]: "";
			
			$output .= $this->callbacks_helper->numbersField($value_padding, $option_name, $name, "padding" );
			
		}
		$output .= "</div>";
		
		
		echo $output;
	}


	public function colorField( $args )
	{
		$name = $args['label_for'];
		$option_name = $args['option_name'];
		$options = get_option( $option_name );
		$value = isset($options[$name]) ?$options[$name]: "";


		$output = '<div class="color-field-wrapper">';
		$output .= '<input type="text" class="cpa-color-picker" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '">';
		$output .= '</div>';

		echo $output;
	}

	public function customLayout($args){


		$name = $args['label_for'];
		$radio_number = (int)$args['radio_repeat'];
		$option_name = $args['option_name'];
		$classes = $args['class'];
		$options = get_option( $option_name );

		$checked = isset($options[$name]["custom"]) ? ($options[$name]["custom"] ? true : false) : false;
		$output = $this->callbacks_helper->checkboxToggleField($classes, $checked, $option_name, $name, "custom" );
		
		
		
		$radio_value = (@$options[$name]["type"])?(int)$options[$name]["type"]:1;
		$output .= "<div class='radio-wrapper'>";
		
		for ($i=1; $i <= $radio_number; $i++) {
		
			$label = (($i == 1) ? "Boxed Layout": "Banner Position");
			
			$output .= $this->callbacks_helper->radioField($i, $radio_value, $option_name, $name, "type", $label );


		}
		
		$output .= "</div>";

		$width_value = (isset($options[$name]["width"]) && $options[$name]["width"] != 0) ?$options[$name]["width"]: "";

		$output .= $this->callbacks_helper->numbersField($width_value, $option_name, $name, "width" );

		echo $output;

	 }

	 	public function checkboxCacheField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$repeat = (int)$args['repeat'];
		$option_name = $args['option_name'];
		$options = get_option( $option_name );
		$checked = array();

		$output = "";

		for ($i=1; $i <= $repeat; $i++) {

			$output .= "<div class='cache-wrapper'>";
			$checked = isset($options[$name][$i]) ? ($options[$name][$i] ? true : false) : false;
			
			$output .= $this->callbacks_helper->checkboxToggleField($classes, $checked, $option_name, $name, $i );
			
			$output .= '<span class="text-wrapper">';
			$output .= ($i < 3) ? ($i == 1) ? "<-| Top Banner" : "<-| Left Banner" : "<-| Right Banner" ;
			$output .= '</span>';
			$output .= "</div>";

		}
		
		echo $output;
	}

}