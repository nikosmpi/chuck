<?php
// SVG Uploads
function chuck_svg_upload($mimes) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';

	return $mimes;
}
// SVG Mimetypes
function chuck_svg_mimetype($data = null, $file = null, $filename = null, $mimes = null) {
	$ext = isset($data['ext']) ? $data['ext'] : '';
	if (strlen($ext) < 1) {
		$exploded = explode('.', $filename);
		$ext      = strtolower(end($exploded));
	}
	if ('svg' === $ext) {
		$data['type'] = 'image/svg+xml';
		$data['ext']  = 'svg';
	} elseif ('svgz' === $ext) {
		$data['type'] = 'image/svg+xml';
		$data['ext']  = 'svgz';
	}
	return $data;
}
// Set Excerpt Length
function chuck_excerpt_length($length) {
	return 40;
}
// Greek to Greeklist Permalinks
if (!function_exists('chuck_greeklist_slugs')) {
	function chuck_greeklist_slugs($text) {
		if (!is_admin()) return $text;
		return Chuck::greeklish($text);
	}
}