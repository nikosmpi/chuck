<?php
// ACF JSON Save Point
if (!function_exists('chuck_acf_json_save_point')) {
	function chuck_acf_json_save_point($path) {
		return get_stylesheet_directory() . '/acf-json';
	}
}


