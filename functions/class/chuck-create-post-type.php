<?php class Chuck_Create_Post_Type {
	public $slug;
	public $singular;
	public $plural;
	public $args;
	public function __construct($slug, $singular, $plural, $args = array()) {
		$this->slug = $slug;
		$this->singular = $singular;
		$this->plural = $plural;
		$this->args = $args;
		add_action('init', array($this, 'create_post_type'));
	}
	// make create_post_type
	function create_post_type() {
		$labels = array(
			'name' => _x($this->plural, 'post type general name'),
			'singular_name' => _x($this->singular, 'post type singular name'),
			'add_new' => _x('Add New', $this->singular),
			'add_new_item' => __('Add New ' . $this->singular),
			'edit_item' => __('Edit ' . $this->singular),
			'new_item' => __('New ' . $this->singular),
			'view_item' => __('View ' . $this->singular),
			'search_items' => __('Search ' . $this->plural),
			'not_found' => __('No ' . $this->plural . ' found'),
			'not_found_in_trash' => __('No ' . $this->plural . ' found in Trash'),
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'rewrite' => array(
				'slug' => $this->slug,
				'with_front' => false
			),
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'menu_icon' => 'dashicons-admin-post',
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'page-attributes'
			)
		);
		$args = array_merge($args, $this->args);
		register_post_type($this->slug, $args);

	}

}