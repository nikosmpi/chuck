<?php
// Image Settings
if (!function_exists('chuck_image_settings')) {
	function chuck_image_settings()
	{
		add_image_size('chuck-big', 1400, 800, true);
		add_image_size('chuck-square', 400, 400, true);
		add_image_size('chuck-single', 800, 500, true);
		// remove_image_size('large');
		// remove_image_size('thumbnail');
		// remove_image_size('medium');
		// remove_image_size('medium_large');
		remove_image_size('1536x1536');
		remove_image_size('2048x2048');
	}
}
add_action('after_setup_theme', 'chuck_image_settings');

// Image Quality
function chuck_image_quality() {
	return 80;
}
add_filter( 'jpeg_quality', 'chuck_image_quality' );