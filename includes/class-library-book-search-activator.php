<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.facebook.com/vermadarsh
 * @since      1.0.0
 *
 * @package    Library_Book_Search
 * @subpackage Library_Book_Search/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Library_Book_Search
 * @subpackage Library_Book_Search/includes
 * @author     Adarsh Verma <adarsh.srmcem@gmail.com>
 */
class Library_Book_Search_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$pg_title = "Book Search";
		if( get_page_by_title( $pg_title ) == NULL ) {
			wp_insert_post( array(
				'post_type' => 'page',
				'post_status' => 'publish',
				'post_title' => $pg_title,
				'post_content' => '[library_book_search]'
			) );
		}
	}

}
