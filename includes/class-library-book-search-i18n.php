<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.facebook.com/vermadarsh
 * @since      1.0.0
 *
 * @package    Library_Book_Search
 * @subpackage Library_Book_Search/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Library_Book_Search
 * @subpackage Library_Book_Search/includes
 * @author     Adarsh Verma <adarsh.srmcem@gmail.com>
 */
class Library_Book_Search_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'library-book-search',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
