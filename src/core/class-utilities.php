<?php
/**
 * @copyright (c) 2024.
 * @author            Alan Fuller (support@fullworksplugins.com)
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

namespace AIDFW_Plugin\Core;

/**
 * Class Utilities
 * @package AIDFW_Plugin\Control
 */
class Utilities {

	/**
	 * @var
	 */
	protected static $instance;

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

	public function register_settings_page_tab( $title, $page, $href, $position ) {
		$this->settings_page_tabs[ $page ][ $position ] = array(
			'title' => $title,
			'href'  => $href,
		);
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
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r -- debug only
			$data = print_r( $data, true );
		}
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- debug only
		error_log( '>>> plugin debug: ' . $data );
	}
}
