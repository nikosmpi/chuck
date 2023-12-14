<?php
// Register Classes
foreach (glob(get_template_directory() . '/functions/class/*.php') as $post_types) {
	require_once $post_types;
};
// Register General Functions
foreach (glob(get_template_directory() . '/functions/general/*.php') as $post_types) {
	require_once $post_types;
};

require_once get_template_directory() . '/functions/hooks.php';