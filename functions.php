<?php
// Register Classes
foreach (glob(get_template_directory() . '/functions/class/*.php') as $classes) {
	require_once $classes;
};
// Register General Functions
foreach (glob(get_template_directory() . '/functions/general/*.php') as $general) {
	require_once $general;
};

require_once get_template_directory() . '/functions/hooks.php';