<?php
// Disable Gutenberg
add_action('init', 'chuck_disable_gutenberg');

// Disable Emojis
add_action('init', 'chuck_disable_emojis');

// Disable oEmbed
add_action('init', 'chuck_disable_oembed');

// Disable Query Strings
// add_action('init', 'chuck_disable_query_strings');

// Disable jQuery Migrate
//add_action('wp_enqueue_scripts', 'chuck_jquery_footer');

// Disable Head Links
add_action('init', 'chuck_disable_head_links');

// Disable Remove Global Styles And SVG Filters
add_action('init', 'chuck_remove_global_styles_and_svg_filters');

// Greek to Greeklist Permalinks
add_filter('sanitize_title', 'chuck_greeklist_slugs', 1);

// Set Excerpt Length
// add_filter( 'excerpt_length', 'chuck_excerpt_length', 999 );

// SVG Uploads & Mimetypes
add_filter('upload_mimes', 'chuck_svg_upload');
add_filter('wp_check_filetype_and_ext', 'chuck_svg_mimetype', 10, 4);

// ACF JSON Save Point
add_filter('acf/settings/save_json', 'chuck_acf_json_save_point');