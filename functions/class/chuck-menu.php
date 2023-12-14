<?php
class Chuck_Menu {
	public static function nav_menu($theme_location = 'primary', $extras = array()) {
		echo self::get_nav_menu($theme_location, $extras);
	}
	public static function get_nav_menu($theme_location = 'primary', $extras = array()) {
		$menu_class = isset($extras['menu_class']) && !empty($extras['menu_class']) ? $extras['menu_class'] : 'menu';
		$container_class = 'menu' === $menu_class ? "$menu_class $menu_class--$theme_location" : $menu_class;
		$show_level_class = isset($extras['show_level_class']) ? (bool) $extras['show_level_class'] : true;
		$wrap_class = "{$menu_class}__list";
		if ($show_level_class) {
			$wrap_class .= " {$menu_class}__list--level-0";
		}
		return wp_nav_menu(array_merge(array(
			'echo' => false,
			'theme_location' => $theme_location,
			'container' => 'div',
			'container_class' => $container_class,
			'menu_class' => $menu_class,
			'show_level_class' => $show_level_class,
			'items_wrap' => "<ul class=\"{$wrap_class}\">%3\$s</ul>",
			'fallback_cb' => false,
			'walker' => new Chuck_Walker_Menu
		), $extras));
	}
	public static function get_menu_items($theme_location = 'primary') {
		$locations = get_nav_menu_locations();
		if (!isset($locations[$theme_location])) {
			return false;
		}
		$menu_id = $locations[$theme_location];
		if (function_exists('wpml_object_id')) {
			$menu_id = wpml_object_id((int) $menu_id, 'nav_menu');
		}
		return wp_get_nav_menu_items($menu_id);
	}
	public static function get_menu_item($menu = 'primary', $item_id = 0) {
		if (is_string($menu)) {
			$menu = self::get_menu_items($menu);
		}
		if (!$item_id) {
			$item_id = get_queried_object_id();
		}
		foreach ((array) $menu as $item) {
			if ((int) $item_id === (int) $item->object_id) {
				return $item;
			}
		}
		return false;
	}
	public static function get_parent_menu_items($menu = 'primary', $item_id = 0) {
		if (is_string($menu)) {
			$menu = self::get_menu_items($menu);
		}
		if (!$menu) {
			return $menu;
		}
		if (!$item_id) {
			$item_id = get_queried_object_id();
		}
		$parent_id = $item_id;
		$parents = array();
		foreach (array_reverse((array) $menu) as $menu_item) {
			if ($menu_item->object_id == $parent_id || $menu_item->ID == $parent_id) {
				if ($parent_id != $item_id) {
					$parents[] = $menu_item;
				}
				if (!($parent_id = $menu_item->menu_item_parent)) {
					return array_reverse($parents);
				}
			}
		}
		return array();
	}
}