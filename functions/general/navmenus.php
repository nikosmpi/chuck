<?php

if (!function_exists('chuck_navmenus')) {
	function chuck_navmenus() {
		register_nav_menus(
			array(
				'header' => esc_html__('Header Menu', 'chuck'),
				'secondary' => esc_html__('Secondary Menu', 'chuck'),
			)
		);
	}
}
add_action('after_setup_theme', 'chuck_navmenus');
