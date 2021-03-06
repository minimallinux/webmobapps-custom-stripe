<?php
/*
Plugin Name: Webmobapps Custom Stripe Plugin
Plugin URI: 
Description: A modified version of WP Full Stripe, a Stripe payments plugin. With Extra Custom Fields and Country Select
Author: P A McGowan
Version: 1.6.1
Author URI: https://webmobapps.com
Text Domain: webmobapp-custom-stripe
Domain Path: /languages
*/

//defines

define( 'STRIPE_API_VERSION', '4.4.0' );

if ( ! defined( 'WP_FULL_STRIPE_NAME' ) ) {
	define( 'WP_FULL_STRIPE_NAME', trim( dirname( plugin_basename( __FILE__ ) ), '/' ) );
}

if ( ! defined( 'WP_FULL_STRIPE_BASENAME' ) ) {
	define( 'WP_FULL_STRIPE_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'WP_FULL_STRIPE_DIR' ) ) {
	define( 'WP_FULL_STRIPE_DIR', WP_PLUGIN_DIR . '/' . WP_FULL_STRIPE_NAME );
}


//Stripe PHP library
if ( ! class_exists( '\Stripe\Stripe' ) ) {
	require_once( dirname( __FILE__ ) . '/vendor/stripe/stripe-php/init.php' );
} else {
	if ( substr( \Stripe\Stripe::VERSION, 0, strpos( \Stripe\Stripe::VERSION, '.' ) ) != substr( STRIPE_API_VERSION, 0, strpos( STRIPE_API_VERSION, '.' ) ) ) {
		wp_die( plugin_basename( __FILE__ ) . ': ' . __( 'Another plugin has loaded an incompatible Stripe API client. Deactivate all other Stripe plugins, and try to activate Full Stripe Free again.' ) );
	}
}

require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'wp-full-stripe-main.php';
register_activation_hook( __FILE__, array( 'MM_WPFSF', 'setup_db' ) );

function webmobapps_custom_stripe_load_plugin_textdomain() {
	load_plugin_textdomain( 'webmobapps-custom-stripe', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'webmobapps_custom_stripe_load_plugin_textdomain' );
