<?php
/*
 * Plugin Name: TLH xVerify
 * Plugin URI: https://github.com/thelearninghouse/lp-builder
 * Description: This plugin incorperates xVerify Form Validation
 * Version: 1.0
 * Author: David Royer - The Learning House
 * Author URI: http://www.learninghouse.com
 * License: GPL2
 */


// Enqueue Scripts
if ( ! is_admin() ) {
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false, false, false );
  wp_enqueue_script( 'jquery' );
}

function tlh_xverify_script() {
  wp_register_script('tlh-xverify-js', plugins_url( 'tlh-xverify/scripts.js' , dirname(__FILE__) ) );
  wp_enqueue_script('tlh-xverify-js');

  wp_register_style('tlh-xverify-css', plugins_url( 'tlh-xverify/form-styles.css' , dirname(__FILE__) ) );
  wp_enqueue_style('tlh-xverify-css');
}
add_action('wp_enqueue_scripts', 'tlh_xverify_script');
