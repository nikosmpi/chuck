<?php
class Chuck_Walker_Menu extends Walker_Nav_Menu {
	public function start_lvl(&$output, $depth = 0, $args = array()) {
		$list_classes = array(
			'__list',
			'__list--submenu'
		);
		if (isset($args->show_level_class) && $args->show_level_class) {
			$list_classes[] = '__list--level-' . ($depth + 1);
		}
		$list_classes_str = Chuck::get_bem($args->menu_class, $list_classes);
		$output .= "<ul class=\"$list_classes_str\">";
	}

	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		$item_classes = array('__item');
		$has_child = false;
		if (isset($item->current) && $item->current) {
			$item_classes[] = '__item--current';
		}
		if (isset($item->current_item_ancestor) && $item->current_item_ancestor) {
			$item_classes[] = '__item--ancestor';
		}
		if (isset($item->current_item_parent) && $item->current_item_parent) {
			$item_classes[] = '__item--parent';
		}
		if (isset($item->has_children) && $item->has_children) {
			$item_classes[] = '__item--has-children';
			$has_child = true;
		}
		$item_classes_str = Chuck::get_bem($args->menu_class, $item_classes);
		if (isset($item->classes[0]) && !empty($item->classes[0])) {
			$item_classes_str .= " {$item->classes[0]}";
		}
		$output .= "<li class=\"$item_classes_str\">";
		$attrs = array_filter(array(
			'title'  => $item->attr_title,
			'target' => $item->target,
			'rel'    => $item->xfn,
			'href'   => (!empty($item->url) && '#' !== $item->url) ? $item->url : '',
			'class'  => "{$args->menu_class}__link site__nocursor"
		),
			function ($attr) {
				return !empty($attr);
			}
		);
		$tag = isset($attrs['href']) ? 'a' : 'span';
		$link_content = $args->link_before
			. apply_filters('the_title', $item->title, $item->ID)
			. $args->link_after;
		$output .= $args->before;
		$output .= Chuck::get_element($tag, $attrs, $link_content);
		if($has_child && $depth === 0) {
			$output .= '<span class="menu__item--has-children-open"></span>';
		}
		$output .= $args->after;

	}
	public function end_lvl(&$output, $depth = 0, $args = array()) {
		$output .= '</ul>';
	}
	function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
		if (isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID])) {
			$element->has_children = true;
			$element->current_item_ancestor = self::any_children_active($element, $children_elements);
		}
		parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
	public static function is_child_active($child) {
		return $child->current || $child->current_item_parent || $child->current_item_ancestor;
	}
	public static function any_children_active($element, $children_elements) {
		if (!isset($children_elements[$element->ID])) {
			return false;
		}
		foreach ($children_elements[$element->ID] as $child) {
			if (self::is_child_active($child)) {
				return true;
			}
			if (self::any_children_active($child, $children_elements)) {
				return true;
			}
		}
		return false;
	}
}