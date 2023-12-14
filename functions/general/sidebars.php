<?php
if (!function_exists('chuck_sidebars')) {
	function chuck_sidebars() {
		register_sidebar(
			array(
				'name' => esc_html__('Main Sidebar', 'chuck'),
				'id' => 'sidebar-main',
				'description' => esc_html__('Main Sidebar', 'chuck'),
				'before_widget' => '<div class="widget mb-4 %2$s clearfix">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="mb-4">',
				'after_title' => '</h3>',
			)
		);
	}
}
add_action('widgets_init', 'chuck_sidebars');
