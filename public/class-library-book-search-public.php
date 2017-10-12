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

		wp_enqueue_style( $this->plugin_name.'-selectize', LBS_PLUGIN_URL . 'public/css/selectize.css' );
		wp_enqueue_style( $this->plugin_name.'-ui', LBS_PLUGIN_URL . 'public/css/jquery-ui.min.css' );
		wp_enqueue_style( $this->plugin_name.'-data-tables', LBS_PLUGIN_URL . 'public/css/jquery.dataTables.min.css' );
		wp_enqueue_style( $this->plugin_name.'-font-awesome', LBS_PLUGIN_URL . 'admin/css/font-awesome.min.css' );
		wp_enqueue_style( $this->plugin_name, LBS_PLUGIN_URL . 'public/css/library-book-search-public.css' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function lbs_enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name.'-selectize', LBS_PLUGIN_URL . 'public/js/selectize.min.js', array( 'jquery' ) );
		wp_enqueue_script( $this->plugin_name.'-ui', LBS_PLUGIN_URL . 'public/js/jquery-ui.min.js', array( 'jquery' ) );
		wp_enqueue_script( $this->plugin_name.'-data-tables', LBS_PLUGIN_URL . 'public/js/jquery.dataTables.min.js', array( 'jquery' ) );
		wp_enqueue_script( $this->plugin_name, LBS_PLUGIN_URL . 'public/js/library-book-search-public.js', array( 'jquery' ) );

		wp_localize_script(
			$this->plugin_name,
			'lbs_public_js_obj',
			array(
				'ajaxurl'		=>	admin_url( 'admin-ajax.php' )
			)
		);

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

	/**
	 * Actions performed to serve the ajax request for searching books
	 */
	public function lbs_search_books() {
		if( isset( $_POST['action'] ) && $_POST['action'] == 'lbs_search_books' ) {

			$book_name = sanitize_text_field( $_POST['book_name'] );
			$min_price = sanitize_text_field( $_POST['min_price'] );
			$max_price = sanitize_text_field( $_POST['max_price'] );
			$rating = sanitize_text_field( $_POST['rating'] );
			$author = sanitize_text_field( $_POST['author'] );
			$publisher = sanitize_text_field( $_POST['publisher'] );

			$args = array(
				's' => $book_name,
				'post_type' => 'book',
				'posts_per_page' => -1,
				'fields' => 'ids',
				'meta_query'    => array(
					'relation'  => 'AND',
					array(
						'key'		=> 'book-price',
						'value'		=> $min_price,
						'compare'	=> '>=',
					),
					array(
						'key'		=> 'book-price',
						'value'		=> $max_price,
						'compare'	=> '<=',
					)
				),
			);

			if( $rating ) {
				$args['meta_query'][] = array(
					'key'		=>	'book-rating',
					'value'		=>	$rating,
					'compare'	=>	'='
				);
			}

			if( $author ) {
				$args['tax_query'][] = array(
					'taxonomy'			=>	'book-author',
					'terms'				=>	$author,
					'field'				=>	'name',
					'include_children'	=>	true,
					'operator'			=>	'LIKE'
				);
			}

			if( $publisher ) {
				$args['tax_query'][] = array(
					'taxonomy'			=>	'book-publisher',
					'terms'				=>	$publisher,
					'field'				=>	'id',
					'include_children'	=>	true,
					'operator'			=>	'IN'
				);
			}

			$book_ids = get_posts( $args );

			$res_html = '';
			if( empty( $book_ids ) ) {
				$msg = __( 'Errrrrror! No Book Found!', LBS_TEXT_DOMAIN );
				$res_html .= '<div class="lbs-error">';
				$res_html .= '<p>' . $msg . '</p>';
				$res_html .= '</div>';
			} else {
				$msg = __( 'Yipeeeee! Books Found!', LBS_TEXT_DOMAIN );
				$res_html .= '<table class="lbs-results-list">';
				$res_html .= '<thead>';
				$res_html .= '<tr>';
				$res_html .= '<th>'.__( 'No.', LBS_TEXT_DOMAIN ).'</th>';
				$res_html .= '<th>'.__( 'Book Name', LBS_TEXT_DOMAIN ).'</th>';
				$res_html .= '<th>'.__( 'Price', LBS_TEXT_DOMAIN ).'</th>';
				$res_html .= '<th>'.__( 'Author', LBS_TEXT_DOMAIN ).'</th>';
				$res_html .= '<th>'.__( 'Publisher', LBS_TEXT_DOMAIN ).'</th>';
				$res_html .= '<th>'.__( 'Rating', LBS_TEXT_DOMAIN ).'</th>';
				$res_html .= '</tr>';
				$res_html .= '</thead>';
				$res_html .= '<tbody>';
				foreach( $book_ids as $index => $bid ) {
					$book = get_post( $bid );
					$book_meta = get_post_meta( $bid );
					$authors = wp_get_object_terms( $bid, 'book-author' );
					$authors_str = '--';
					if( !empty( $authors ) ) {
						$authors_str = '';
						foreach( $authors as $author ) {
							$author_link = get_term_link( $author->term_id, 'book-author' );
							$authors_str .= '<a href="'.$author_link.'">'.$author->name.'</a>,';
						}
						$authors_str = rtrim( $authors_str, ',' );
					}

					$publishers = wp_get_object_terms( $bid, 'book-publisher' );
					$publishers_str = '--';
					if( !empty( $publishers ) ) {
						$publishers_str = '';
						foreach( $publishers as $publisher ){
							$publisher_link = get_term_link( $publisher->term_id, 'book-publisher' );
							$publishers_str .= '<a href="'.$publisher_link.'">'.$publisher->name.'</a>,';
						}
						$publishers_str = rtrim( $publishers_str, ',' );
					}

					$res_html .= '<tr>';
					$res_html .= '<td>' . ( $index + 1 ) . '.</td>';
					$res_html .= '<td><a target="_blank" href="'.get_permalink( $bid ).'" title="'.$book->post_title.'">'.$book->post_title.'</a></td>';
					$res_html .= '<td>&#36 '.$book_meta['book-price'][0].'</td>';
					$res_html .= '<td>'.$authors_str.'</td>';
					$res_html .= '<td>'.$publishers_str.'</td>';
					$res_html .= '<td>';
					$res_html .= '<div class="rating-stars">';
					$res_html .= '<ul>';
					for( $i = 1; $i <= 5; $i++ ) {
						$rating_class = '';
						if( $i <= $book_meta['book-rating'][0] ) {
							$rating_class = 'selected';
						}

						$res_html .= '<li class="star '.$rating_class.'"><i class="fa fa-star"></i></li>';
					}
					$res_html .= '</ul>';
					$res_html .= '</div>';
					$res_html .= '</td>';
					$res_html .= '</tr>';
				}
				$res_html .= '</tbody>';
				$res_html .= '</table>';
			}

			$result = array(
				'message'		=>	__( $msg, LBS_TEXT_DOMAIN ),
				'html'			=>	$res_html,
				'books_count'	=>	count( $book_ids )
			);
			wp_send_json_success( $result );
			die;
		}
	}

}
