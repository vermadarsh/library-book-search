<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.facebook.com/vermadarsh
 * @since      1.0.0
 *
 * @package    Library_Book_Search
 * @subpackage Library_Book_Search/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Library_Book_Search
 * @subpackage Library_Book_Search/admin
 * @author     Adarsh Verma <adarsh.srmcem@gmail.com>
 */
class Library_Book_Search_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function lbs_enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Library_Book_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Library_Book_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/library-book-search-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function lbs_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Library_Book_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Library_Book_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/library-book-search-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register A CPT - Books
	 */
	public function lbs_register_books_cpt() {
		$labels = array(
			'name'					=>	__( 'Books', LBS_TEXT_DOMAIN ),
			'singular_name'			=>	__( 'Book', LBS_TEXT_DOMAIN ),
			'menu_name'				=>	__( 'Books', 'admin menu', LBS_TEXT_DOMAIN ),
			'name_admin_bar'		=>	__( 'Book', 'add new on admin bar', LBS_TEXT_DOMAIN ),
			'add_new'				=>	__( 'Add New', LBS_TEXT_DOMAIN ),
			'add_new_item'			=>	__( 'Add New Book', LBS_TEXT_DOMAIN ),
			'new_item'				=>	__( 'New Book', LBS_TEXT_DOMAIN ),
			'edit_item'				=>	__( 'Edit Book', LBS_TEXT_DOMAIN ),
			'view_item'				=>	__( 'View Book', LBS_TEXT_DOMAIN ),
			'all_items'				=>	__( 'All Books', LBS_TEXT_DOMAIN ),
			'search_items'			=>	__( 'Search Books', LBS_TEXT_DOMAIN ),
			'parent_item_colon'		=>	__( 'Parent Books:', LBS_TEXT_DOMAIN ),
			'not_found'				=>	__( 'No Books Found.', LBS_TEXT_DOMAIN ),
			'not_found_in_trash'	=>	__( 'No Books Found In Trash.', LBS_TEXT_DOMAIN )
		);

		$args = array(
			'labels'				=>	$labels,
			'public'				=>	true,
			'menu_icon'				=>	'dashicons-book',
			'publicly_queryable'	=>	true,
			'show_ui'				=>	true,
			'show_in_menu'			=>	true,
			'query_var'				=>	true,
			'rewrite'				=>	array( 'slug' => 'book' ),
			'capability_type'		=>	'post',
			'has_archive'			=>	true,
			'hierarchical'			=>	false,
			'menu_position'			=>	null,
			'supports'				=>	array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);
		register_post_type( 'book', $args );
	}

	/**
	 * Register Taxonomies for CPT - Books
	 */
	public function lbs_register_books_cpt_taxonomies() {
		//Author taxonomy
		$a_labels = array(
			'name'				=> __( 'Authors', LBS_TEXT_DOMAIN ),
			'singular_name'		=> __( 'Author', LBS_TEXT_DOMAIN ),
			'search_items'		=> __( 'Search Authors', LBS_TEXT_DOMAIN ),
			'all_items'			=> __( 'All Authors', LBS_TEXT_DOMAIN ),
			'parent_item'		=> __( 'Parent Author', LBS_TEXT_DOMAIN ),
			'parent_item_colon'	=> __( 'Parent Author:', LBS_TEXT_DOMAIN ),
			'edit_item'			=> __( 'Edit Author', LBS_TEXT_DOMAIN ),
			'update_item'		=> __( 'Update Author', LBS_TEXT_DOMAIN ),
			'add_new_item'		=> __( 'Add Author', LBS_TEXT_DOMAIN ),
			'new_item_name'		=> __( 'New Author Name', LBS_TEXT_DOMAIN ),
			'menu_name'			=> __( 'Authors', LBS_TEXT_DOMAIN ),
		);
		$a_args = array(
			'hierarchical'		=> true,
			'labels'			=> $a_labels,
			'show_ui'			=> true,
			'show_admin_column'	=> true,
			'query_var'			=> true,
			'rewrite'			=> array( 'slug' => 'book-author' ),
		);
		register_taxonomy( 'book-author', array( 'book' ), $a_args );

		//Publisher taxonomy
		$p_labels = array(
			'name'				=> __( 'Publishers', LBS_TEXT_DOMAIN ),
			'singular_name'		=> __( 'Publisher', LBS_TEXT_DOMAIN ),
			'search_items'		=> __( 'Search Publishers', LBS_TEXT_DOMAIN ),
			'all_items'			=> __( 'All Publishers', LBS_TEXT_DOMAIN ),
			'parent_item'		=> __( 'Parent Publisher', LBS_TEXT_DOMAIN ),
			'parent_item_colon'	=> __( 'Parent Publisher:', LBS_TEXT_DOMAIN ),
			'edit_item'			=> __( 'Edit Publisher', LBS_TEXT_DOMAIN ),
			'update_item'		=> __( 'Update Publisher', LBS_TEXT_DOMAIN ),
			'add_new_item'		=> __( 'Add Publisher', LBS_TEXT_DOMAIN ),
			'new_item_name'		=> __( 'New Publisher Name', LBS_TEXT_DOMAIN ),
			'menu_name'			=> __( 'Publishers', LBS_TEXT_DOMAIN ),
		);
		$p_args = array(
			'hierarchical'		=> true,
			'labels'			=> $p_labels,
			'show_ui'			=> true,
			'show_admin_column'	=> true,
			'query_var'			=> true,
			'rewrite'			=> array( 'slug' => 'book-publisher' ),
		);
		register_taxonomy( 'book-publisher', array( 'book' ), $p_args );
	}
}
