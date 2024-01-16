<?php
/**
 * @copyright (c) 2019.
 * @author            Alan Fuller (support@fullworks)
 * @licence           GPL V3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link                  https://fullworks.net
 *
 * This file is part of Fullworks Plugins.
 *
 *     Fullworks Plugins is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     Fullworks Plugins is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with   Fullworks Plugins.  https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 *
 */


namespace AI_Descriptions_For_WooComerce\Core;


use DateTime;
use DateTimeZone;
use WP_Http;
use WP_Error;


/**
 * Class Utilities
 * @package AI_Descriptions_For_WooComerce\Control
 */
class Utilities {

	/**
	 * @var
	 */
	protected static $instance;


	/**
	 * @var
	 */
	protected $utility_data;

	protected $settings_page_tabs;

	/**
	 * Utilities constructor.
	 */
	public function __construct() {

	}

	/**
	 * @return Utilities
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @param  $message ( WP_Error or array or string )
	 */
	public static function error_log( $message, $called_from = 'Log' ) {
		if ( WP_DEBUG === true ) {
			if ( is_wp_error( $message ) ) {
				$error_string = $message->get_error_message();
				$error_code   = $message->get_error_code();
				error_log( $called_from . ':' . $error_code . ':' . $error_string );

				return;
			}
			if ( is_array( $message ) || is_object( $message ) ) {
				error_log( $called_from . ':' . print_r( $message, true ) );

				return;
			}
			error_log( 'Log:' . $message );

			return;
		}
	}





	public function register_settings_page_tab( $title, $page, $href, $position ) {
		$this->settings_page_tabs[ $page ][ $position ] = array( 'title' => $title, 'href' => $href );

	}

	public function get_settings_page_tabs( $page ) {
		$tabs = $this->settings_page_tabs[ $page ];
		ksort( $tabs );

		return $tabs;
	}


	public function debug_log( $data ) {
		if ( ! defined( 'WP_DEBUG' ) || true !== WP_DEBUG ) {
			return;
		}
		if ( is_array( $data ) ) {
			$data = print_r( $data, true );
		}
		error_log( '>>> plugin debug: ' . $data );
	}

}
