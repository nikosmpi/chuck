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
