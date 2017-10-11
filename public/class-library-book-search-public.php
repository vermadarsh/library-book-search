<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.facebook.com/vermadarsh
 * @since      1.0.0
 *
 * @package    Library_Book_Search
 * @subpackage Library_Book_Search/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Library_Book_Search
 * @subpackage Library_Book_Search/public
 * @author     Adarsh Verma <adarsh.srmcem@gmail.com>
 */
class Library_Book_Search_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function lbs_enqueue_styles() {

		wp_enqueue_style( $this->plugin_name.'-font-awesome', LBS_PLUGIN_URL . 'admin/css/font-awesome.min.css' );
		wp_enqueue_style( $this->plugin_name, LBS_PLUGIN_URL . 'public/css/library-book-search-public.css' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function lbs_enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, LBS_PLUGIN_URL . 'public/js/library-book-search-public.js', array( 'jquery' ) );

	}

	/**
	 * Actions performed to set the template for the shortcode
	 */
	public function lbs_book_search_shortcode_template() {
		$shortcode_template = LBS_PLUGIN_PATH . 'public/templates/lbs-shortcode.php';
		if( file_exists( $shortcode_template ) ) {
			include $shortcode_template;
		}
	}

	/**
	 * Actions performed to set the template for the book details
	 */
	public function lbs_book_detail_page_template( $template ) {
		global $post;
		$book_details_template = LBS_PLUGIN_PATH . 'public/templates/lbs-book-details.php';
		if ( $post->post_type == 'book' && file_exists( $book_details_template ) ) {
			$template = $book_details_template;
		}
		return $template;
	}

}
