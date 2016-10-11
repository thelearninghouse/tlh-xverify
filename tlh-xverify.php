<?php
/*
 * Plugin Name: TLH xVerify
 * Plugin URI: https://github.com/thelearninghouse/tlh-xverify
 * Description: This plugin incorperates xVerify Form Validation
 * Version: 1.1
 * Author: David Royer - The Learning House
 * Author URI: http://www.learninghouse.com
 * License: GPL2
 GitHub Plugin URI: https://github.com/thelearninghouse/tlh-xverify
  GitHub Branch: master
 */

// Enqueue Scripts
 if ( ! is_admin() ) {
 wp_deregister_script( 'jquery' );
 wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false, false, false );
 wp_enqueue_script( 'jquery' );
 }

function tlh_enqueue_xverify_scripts() {
  wp_register_script('tlh-xverify-js', plugins_url( 'tlh-xverify/scripts.js' , dirname(__FILE__) ) );
  wp_enqueue_script('tlh-xverify-js');

  // wp_register_style('tlh-xverify-css', plugins_url( 'tlh-xverify/form-styles.css' , dirname(__FILE__) ) );
  // wp_enqueue_style('tlh-xverify-css');
}
add_action('wp_enqueue_scripts', 'tlh_enqueue_xverify_scripts', 999);



// Injected Styles into WP Head

function inject_styles_into_head() {

  $base_styles =
  ".requestinfo ol li {
    position: relative;
  }
  .FormError {
    z-index: 9999;
    font-weight: normal;
    border-radius: 3px;
    font-size: 15px;
    background: #151515;
    color: #f9f9f9;
    display: inline-block;
    background-image: url('/wp-content/plugins/tlh-xverify/attention.svg');
    background-position: 5% center;
    background-repeat: no-repeat;
    text-align: left;
    padding-left: 35px;
    background-size: 15px;
    padding-top: 5px;
    padding: 8px 10px 8px 35px;
    position: relative;

  }";

  $options_array = get_option( 'tlh_xverify_settings_option_name');

  $tlhx_font_weight = $options_array['tlhx_font_weight'];
  $tlhx_custom_css = $options_array['tlhx_custom_css'];

  $output = $base_styles . ' ' . $tlhx_custom_css;


  echo '<style>' . $output . '</style>';
}
add_action('wp_head','inject_styles_into_head');



// Settings Page
/**
 * Generated by the WordPress Option Page generator
 * at http://jeremyhixon.com/wp-tools/option-page/
 */

class TLHXVerifySettings {
	private $tlh_xverify_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'tlh_xverify_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'tlh_xverify_settings_page_init' ) );
	}

	public function tlh_xverify_settings_add_plugin_page() {
		add_menu_page(
			'TLH xVerify Settings', // page_title
			'TLH xVerify Settings', // menu_title
			'manage_options', // capability
			'tlh-xverify-settings', // menu_slug
			array( $this, 'tlh_xverify_settings_create_admin_page' ), // function
			'dashicons-feedback', // icon_url
			3 // position
		);
	}

	public function tlh_xverify_settings_create_admin_page() {
		$this->tlh_xverify_settings_options = get_option( 'tlh_xverify_settings_option_name' ); ?>

		<div class="wrap">
			<h2>TLH xVerify Settings</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php

          // $options_array = get_option( 'tlh_xverify_settings_option_name');
          // $form_css = $options_array['tlhx_custom_css'];
          //
          // $plugin_dir = plugin_dir_path( __FILE__ );
          // $css_dir = $plugin_dir . 'css';
          //
          // if ( !is_dir($css_dir) ) {
          //   mkdir($plug_dir . 'css', 0755);
          // }
          //
          // file_put_contents($css_dir. '/' . 'dynamic-form-styles' . '.css', $form_css, LOCK_EX); // Save it a

          // echo $test;
					settings_fields( 'tlh_xverify_settings_option_group' );
					do_settings_sections( 'tlh-xverify-settings-admin' );
					submit_button();
				?>
			</form>
		</div>

	<?php }

	public function tlh_xverify_settings_page_init() {
		register_setting(
			'tlh_xverify_settings_option_group', // option_group
			'tlh_xverify_settings_option_name', // option_name
			array( $this, 'tlh_xverify_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'tlh_xverify_settings_setting_section', // id
			'Settings', // title
			array( $this, 'tlh_xverify_settings_section_info' ), // callback
			'tlh-xverify-settings-admin' // page
		);

		add_settings_field(
			'tlhx_custom_css', // id
			'Custom CSS', // title
			array( $this, 'tlhx_custom_css_callback' ), // callback
			'tlh-xverify-settings-admin', // page
			'tlh_xverify_settings_setting_section' // section
		);

    // add_settings_field(
		// 	'tlhx_font_weight', // id
		// 	'Use Font Weight Instead of Bold?', // title
		// 	array( $this, 'tlhx_font_weight_callback' ), // callback
		// 	'tlh-xverify-settings-admin', // page
		// 	'tlh_xverify_settings_setting_section' // section
		// );
    //
    // add_settings_field(
    //   'error_message_background_color', // id
    //   'Error Message Background Color', // title
    //   array( $this, 'error_message_background_color_callback' ), // callback
    //   'tlh-xverify-settings-admin', // page
    //   'tlh_xverify_settings_setting_section' // section
    // );
    //
		// add_settings_field(
		// 	'select_field_1_1', // id
		// 	'Select Field 1', // title
		// 	array( $this, 'select_field_1_1_callback' ), // callback
		// 	'tlh-xverify-settings-admin', // page
		// 	'tlh_xverify_settings_setting_section' // section
		// );
	}

	public function tlh_xverify_settings_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['tlhx_custom_css'] ) ) {
			$sanitary_values['tlhx_custom_css'] = sanitize_text_field( $input['tlhx_custom_css'] );
		}

    // if ( isset( $input['tlhx_font_weight'] ) ) {
		// 	$sanitary_values['tlhx_font_weight'] = sanitize_text_field( $input['tlhx_font_weight'] );
		// }
    //
    // if ( isset( $input['error_message_background_color'] ) ) {
    //   $sanitary_values['error_message_background_color'] =  $input['error_message_background_color'];
    // }
    //
    //
		// if ( isset( $input['select_field_1_1'] ) ) {
		// 	$sanitary_values['select_field_1_1'] = $input['select_field_1_1'];
		// }

		return $sanitary_values;
	}

	public function tlh_xverify_settings_section_info() {

	}

	public function tlhx_custom_css_callback() {
    $test_value = isset( $this->tlh_xverify_settings_options['tlhx_custom_css'] ) ? esc_attr( $this->tlh_xverify_settings_options['tlhx_custom_css']) : '';
    ?>
			<textarea class="regular-text" rows="6" cols="50" type="text" style="resize:none;" name="tlh_xverify_settings_option_name[tlhx_custom_css]" id="tlhx_custom_css" value="<?php echo $test_value; ?>"><?php echo $test_value; ?></textarea> <?php

	}



}
if ( is_admin() )
	$tlh_xverify_settings = new TLHXVerifySettings();

/*
 * Retrieve this value with:
 * $tlh_xverify_settings_options = get_option( 'tlh_xverify_settings_option_name' ); // Array of All Options
 * $tlhx_custom_css = $tlh_xverify_settings_options['tlhx_custom_css']; // Text Input 1
 * $select_field_1_1 = $tlh_xverify_settings_options['select_field_1_1']; // Select Field 1
 */
