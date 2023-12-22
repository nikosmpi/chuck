<?php
// Disable Comments
function chuck_disable_comments_post_types_support()
{
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if (post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}
function chuck_disable_comments_status()
{
	return false;
}
function chuck_disable_comments_hide_existing_comments($comments)
{
	$comments = array();
	return $comments;
}
function chuck_disable_comments_admin_menu()
{
	remove_menu_page('edit-comments.php');
}
function chuck_disable_comments_admin_menu_redirect()
{
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url());
		exit;
	}
}
function chuck_disable_comments_dashboard()
{
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
function chuck_disable_comments_admin_bar()
{
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
}


