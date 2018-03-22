<?php 
/**
 * @package  MBWPBanners
 */
namespace Inc\Api\Callbacks;

class CallbacksHelper
{

    function checkboxToggleField( $classes, $checked, $option_name, $field_name, $subfield_name = "" ){

        $sub_name = ($subfield_name == "") ? "": $subfield_name;
        $sub_name_wrap = ($sub_name == "") ? "" : "[" . $sub_name . "]";

        $output = '<div class="' . $classes . '">';
        $output .= "<input type='checkbox' id='${field_name}${sub_name}' name='${option_name}[${field_name}]$sub_name_wrap' value='1'" . ( $checked ? "checked":"" ) . ">";
        $output .= "<label for=${field_name}${sub_name}><div></div></label>";
        $output .= '</span></div>';

        return $output;

    }

    function numbersField($value, $option_name, $field_name, $subfield_name = "" ){

        $sub_name = ($subfield_name == "") ? "": $subfield_name;
        $sub_name_wrap = ($sub_name == "") ? "" : "[" . $sub_name . "]";

        $output = '<input type="number" class="small-text" id="' . $field_name . $sub_name . '" name="' . $option_name . '[' . $field_name . ']' . $sub_name_wrap  . '" value="' . $value . '" placeholder="' . $sub_name . '" min="0">';

        return $output;

    }

    function radioField($value, $value_checked, $option_name, $field_name, $subfield_name = "", $label = "" ){

        $sub_name = ($subfield_name == "") ? "": $subfield_name;
        $sub_name_wrap = ($sub_name == "") ? "" : "[" . $sub_name . "]";
        $label_val = ($label == "") ? $value : $label;

        $output = "<div class='radio-wrap'><input type='radio' id='${field_name}${value}' name='${option_name}[${field_name}]${sub_name_wrap}' value='${value}'" . ( $value == $value_checked ? "checked":"" ) . ">";
        $output .= "<label for=${field_name}${value}>" . $label_val . "</label></div>";

        return $output;

    }
    
}