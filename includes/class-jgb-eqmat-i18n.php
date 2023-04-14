<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://empdigital.cl
 * @since      1.0.0
 *
 * @package    Jgb_EqMat
 * @subpackage Jgb_EqMat/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Jgb_EqMat
 * @subpackage Jgb_EqMat/includes
 * @author     Jorge Garrido <jegschl@gmail.com>
 */
class Jgb_EqMat_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'jgb-eqmat',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
