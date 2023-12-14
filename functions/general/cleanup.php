<?php
function chuck_disable_gutenberg()
{
	function chuck_disable_gutenberg_scripts() 
	{
		wp_dequeue_style('wp-block-library');
		wp_dequeue_style('wp-block-library-theme');
		wp_dequeue_style('wc-block-style');
		wp_dequeue_style('global-styles');
	}
	add_action('wp_enqueue_scripts', 'chuck_disable_gutenberg_scripts');
	add_filter('use_block_editor_for_post', '__return_false');
	add_filter('gutenberg_use_widgets_block_editor', '__return_false');
	add_filter('use_widgets_block_editor', '__return_false');
}

function chuck_disable_emojis()
{
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	add_filter('tiny_mce_plugins', 'chuck_disable_emojicons_tinymce');
	add_filter('emoji_svg_url', '__return_false');
	function chuck_disable_emojicons_tinymce($plugins)
	{
		if (is_array($plugins)) {
			return array_diff($plugins, array('wpemoji'));
		} else {
			return array();
		}
	}
}

function chuck_disable_oembed()
{
	remove_action('wp_head', 'rest_output_link_wp_head', 10);
	remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
	remove_action('rest_api_init', 'wp_oembed_register_route');
	add_filter('embed_oembed_discover', '__return_false');
	remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'wp_oembed_add_host_js');
	add_filter('rewrite_rules_array', 'chuck_disable_embeds_rewrites');
	function chuck_disable_embeds_rewrites($rules)
	{
		foreach ($rules as $rule => $rewrite) {
			if (false !== strpos($rewrite, 'embed=true')) {
				unset($rules[$rule]);
			}
		}
		return $rules;
	}
}

function chuck_disable_query_strings()
{
	function chuck_rm_query_string($src)
	{
		$parts = explode('?ver', $src);
		return $parts[0];
	}
	if (!is_admin()) {
		add_filter('script_loader_src', 'chuck_rm_query_string', 15, 1);
		add_filter('style_loader_src', 'chuck_rm_query_string', 15, 1);
	}
}

function chuck_jquery_footer()
{
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.7.0.min.js', false, time(), true);
}

function chuck_disable_head_links()
{
	// Disable XML-RPC, RSD, WLW links
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	add_filter('xmlrpc_enabled', '__return_false');
	// Disable shortlink
	remove_action('wp_head', 'wp_shortlink_wp_head');
	// Disable generator (WP version)
	remove_action('wp_head', 'wp_generator');
	// Disable recent comments style
	add_filter('show_recent_comments_widget_style', '__return_false');
	// Remove Admin Bar
	show_admin_bar(false);
}

function chuck_remove_global_styles_and_svg_filters()
{
	remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
	remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
}



