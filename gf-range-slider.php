<?php
/*
Plugin Name: Gravity Form Range Slider
Plugin URI: http://www.rabindrapantha.com.np
Description: A simple add-on to use range slider to include in a form.
Version: 1.0
Author: Raveendra Panta
Author URI: http://www.rabindrapantha.com.np
Text Domain: gf-range-slider
Domain Path: /languages
*/

define( 'GF_RANGE_SLIDER_FIELD_ADDON_VERSION', '1.0' );

add_action( 'gform_loaded', array( 'GF_Range_Slider_Field_AddOn_Bootstrap', 'load' ), 5 );

class GF_Range_Slider_Field_AddOn_Bootstrap {

    public static function load() {

        if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
            return;
        }

        require_once( 'class-gf-range-slider.php' );

        GFAddOn::register( 'GFRangeSliderAddOn' );
    }

}
