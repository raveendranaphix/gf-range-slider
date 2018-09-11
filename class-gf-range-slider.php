<?php

GFForms::include_addon_framework();

class GFRangeSliderAddOn extends GFAddOn {
	protected $_version = GF_RANGE_SLIDER_FIELD_ADDON_VERSION;
	protected $_min_gravityforms_version = '1.9';
	protected $_slug = 'gf-range-slider';
	protected $_path = 'gf-range-slider/gf-range-slider.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Gravity Form Range Slider Field Add-On';
	protected $_short_title = 'Range Slider Field Add-On';

	private static $_instance = null;

	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function pre_init() {
		parent::pre_init();

		if ( $this->is_gravityforms_supported() && class_exists( 'GF_Field' ) ) {
			require_once( 'includes/class-range-slider-gf-field.php' );
		}
	}

	public function init_admin() {
		parent::init_admin();

		add_filter( 'gform_tooltips', array( $this, 'tooltips' ) );
		add_action( 'gform_field_appearance_settings', array( $this, 'field_appearance_settings' ), 10, 2 );
	}

	public function scripts() {
		$scripts = array(
			array(
				'handle'  => 'range_slider_js',
				'src'     => $this->get_base_url() . '/js/rangeslider.min.js',
				'version' => $this->_version,
				'deps'    => array( 'jquery' ),
				'enqueue' => array(
					array( 'admin_page' => array( 'form_settings' ) ),
					array( 'field_types' => array( 'range_slider' ) ),
				),
				'in_footer' => true,
			),
			array(
				'handle'  => 'range_slider_script_js',
				'src'     => $this->get_base_url() . '/js/range_slider_script.js',
				'version' => $this->_version,
				'deps'    => array( 'jquery' ),
				'enqueue' => array(
					array( 'admin_page' => array( 'form_settings' ) ),
					array( 'field_types' => array( 'range_slider' ) ),
				),
				'in_footer' => true,
			),

		);

		return array_merge( parent::scripts(), $scripts );
	}

	public function styles() {
		$styles = array(
			array(
				'handle'  => 'range_slider_css',
				'src'     => $this->get_base_url() . '/css/rangeslider.css',
				'version' => $this->_version,
				'enqueue' => array(
					array( 'admin_page' => array( 'form_settings' ) ),
					array( 'field_types' => array( 'range_slider' ) )
				)
			),
			array(
				'handle'  => 'range_slider_style_css',
				'src'     => $this->get_base_url() . '/css/range_slider_style.css',
				'version' => $this->_version,
				'enqueue' => array(
					array( 'admin_page' => array( 'form_settings' ) ),
					array( 'field_types' => array( 'range_slider' ) )
				)
			),
		);

		return array_merge( parent::styles(), $styles );
	}

	public function tooltips( $tooltips ) {
		$range_slider_tooltips = array(
			'input_class_setting' => sprintf( '<h6>%s</h6>%s', esc_html__( 'Input CSS Classes', 'range-slider' ), esc_html__( 'The CSS Class names to be added to the field input.', 'range-slider' ) ),
		);

		return array_merge( $tooltips, $range_slider_tooltips );
	}

	public function field_appearance_settings( $position, $form_id ) {
		// Add our custom setting just before the 'Custom CSS Class' setting.
		if ( $position == 250 ) {
			?>
			<li class="input_class_setting field_setting">
				<label for="input_class_setting">
					<?php esc_html_e( 'Input CSS Classes', 'range-slider' ); ?>
					<?php gform_tooltip( 'input_class_setting' ) ?>
				</label>
				<input id="input_class_setting" type="text" class="fieldwidth-1" onkeyup="SetInputClassSetting(jQuery(this).val());" onchange="SetInputClassSetting(jQuery(this).val());"/>
			</li>

			<?php
		}
	}
}
