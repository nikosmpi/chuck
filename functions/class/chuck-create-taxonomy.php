<?php class Chuck_Create_Taxonomy {
	public $slug;
	public $singular;
	public $plural;
	public $args;
	public $post_type;
	public function __construct($slug, $singular, $plural, $post_type = array('post'), $args = array()) {
		$this->slug = $slug;
		$this->singular = $singular;
		$this->plural = $plural;
		$this->args = $args;
		$this->post_type = $post_type;
		add_action('init', array($this, 'create_taxonomy'));
	}
	function create_taxonomy() {
		$labels = array(
			'name' => _x($this->plural, 'taxonomy general name'),
			'singular_name' => _x($this->singular, 'taxonomy singular name'),
			'search_items' => __('Search ' . $this->plural),
			'all_items' => __('All ' . $this->plural),
			'parent_item' => __('Parent ' . $this->singular),
			'parent_item_colon' => __('Parent ' . $this->singular . ':'),
			'edit_item' => __('Edit ' . $this->singular),
			'update_item' => __('Update ' . $this->singular),
			'add_new_item' => __('Add New ' . $this->singular),
			'new_item_name' => __('New ' . $this->singular . ' Name'),
			'menu_name' => __($this->plural),
		);
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
			'rewrite' => array(
				'slug' => $this->slug,
				'with_front' => false
			),
		);
		$args = array_merge($args, $this->args);
		register_taxonomy($this->slug, $this->post_type, $args);
	}
}