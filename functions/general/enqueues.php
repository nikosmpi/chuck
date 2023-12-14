<?php
if ( ! function_exists( 'chuck_styles_scripts' ) ) {
	function chuck_styles_scripts() {
		// CSS
		wp_enqueue_style('chuck-styles', get_template_directory_uri() . '/assets/dist-css/main.css', array(), time(), 'all');
		// JavaScript
		wp_enqueue_script('chuck-scripts', get_template_directory_uri() . '/assets/dist-js/main.js', array('jquery'), time(), true);
		// Localize
		wp_localize_script('chuck-scripts', 'urls', [
			'home'   		  => home_url(),
			'theme'  		  => get_stylesheet_directory_uri(),
			'api' 			  => site_url('/wp-json' ),
		]);
	}
}
add_action('wp_enqueue_scripts', 'chuck_styles_scripts');
