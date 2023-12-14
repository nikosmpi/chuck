<?php
if (!function_exists('chuck_setup_theme')) {
	function chuck_setup_theme() {
		// Enable featured images
		add_theme_support('post-thumbnails');
		// Enable RSS feeds
		add_theme_support('automatic-feed-links');
		// Enable HTML5 markup
		add_theme_support('html5', array(
			'comment-list', 
			'comment-form', 
			'search-form', 
			'gallery', 
			'caption'
		));
		// Enable title meta tag to <head>
		add_theme_support('title-tag');
		// Enable Widgets refresh from Customizer
		//add_theme_support('customize-selective-refresh-widgets');
		// Set max content width (embedded)
		if (!isset($content_width)) {
			$content_width = 1400;
		}
		// Load translations
		//load_theme_textdomain('chuck', get_template_directory() . '/languages');

		// Load Ajax
		
	}
}
add_action('after_setup_theme', 'chuck_setup_theme');