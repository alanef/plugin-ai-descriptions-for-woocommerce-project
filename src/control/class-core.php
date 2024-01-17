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

namespace AIDFW_Plugin\Control;

use AIDFW_Plugin\Admin\Admin;
use AIDFW_Plugin\Admin\Admin_Settings;
use AIDFW_Plugin\Business\Purge;
use AIDFW_Plugin\Core\Process_Spam_Checks;
use AIDFW_Plugin\Core\Utilities;
use AIDFW_Plugin\Data\Log;
use AIDFW_Plugin\FrontEnd\FrontEnd;
use AIDFW_Plugin\Business\Email_Reports;
use AIDFW_Plugin\Admin\Mark_Spam;

/**
 * Class Core
 * @package AIDFW_Plugin\Control
 */
class Core {
	/**
	 * @var string
	 */
	protected $plugin_name;
	/**
	 * @var string
	 */
	protected $version;
	/**
	 * @var Log
	 */
	protected $log;
	/** @var Utilities $utilities */
	protected $utilities;


	public function __construct(  ) {
		$this->plugin_name = 'ai-descriptions-for-woocommerce';
		$this->version     = AIDFW_PLUGIN_VERSION;
		$this->utilities   = new Utilities();

	}

	/**
	 *
	 */
	public function run() {
		$this->set_options_data();
		$this->set_locale();
		$this->settings_pages();
		$this->define_admin_hooks();
	}

	/**
	 *
	 */
	private function set_options_data() {
		// set up options & cron - do it here rather than activator to cover multi sites
		$options = get_option( 'ai-descriptions-for-woocommerce' );
		if ( false === $options ) {
			add_option( 'ai-descriptions-for-woocommerce', Admin_Settings::option_defaults( 'ai-descriptions-for-woocommerce' ) );
		}
	}

	/**
	 *
	 */
	private function set_locale() {
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
	}

	/**
	 *
	 */
	private function settings_pages() {
		$settings = new Admin_Settings( $this->get_plugin_name(), $this->get_version(), $this->utilities );
		add_action( 'admin_menu', array( $settings, 'settings_setup' ) );
		add_action( 'init', array( $settings, 'plugin_action_links' ) );
	}

	/**
	 * @return string
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * @return string
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 *
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Admin( $this->get_plugin_name(), $this->get_version(), $this->utilities);
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_scripts' ) );

		add_action( 'woocommerce_before_product_object_save', array( $plugin_admin,'on_product_save'), 10, 1 );


	}



	/**
	 *
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'ai-descriptions-for-woocommerce',
			false,
			AIDFW_PLUGIN_DIR . 'languages/'
		);
	}
}
