<?php
/**
 * Class Core
 *
 * The Core class handles the initialization and setup of the plugin.
 */

namespace AIDFW_Plugin\Control;

use /**
 * Class Admin
 *
 * This class is responsible for handling the administration functionality of the plugin.
 */
	AIDFW_Plugin\Admin\Admin;
use /**
 * Class Admin_Settings
 *
 * Represents the administrative settings for the AIDFW Plugin.
 */
	AIDFW_Plugin\Admin\Admin_Settings;
use /**
 * Class Purge
 *
 * This class handles the purging of data within the AIDFW Plugin.
 */
	AIDFW_Plugin\Business\Purge;
use /**
 * Class Core\Process_Spam_Checks
 *
 * The Process_Spam_Checks class is responsible for processing spam checks on user-submitted data.
 * It performs various checks to determine if the data is likely to be spam or not.
 *
 * @package AIDFW_Plugin\Core
 */
	AIDFW_Plugin\Core\Process_Spam_Checks;
use /**
 * Class Utilities
 *
 * This class provides utility methods for the plugin.
 */
	AIDFW_Plugin\Core\Utilities;
use /**
 * Class Log
 *
 * The Log class is responsible for handling the logging of messages to a file.
 *
 * @package AIDFW_Plugin\Data
 */
	AIDFW_Plugin\Data\Log;
use /**
 * Namespace AIDFW_Plugin\FrontEnd
 *
 * This namespace contains classes related to the front-end functionality of the plugin.
 */
	AIDFW_Plugin\FrontEnd\FrontEnd;
use /**
 * Class Email_Reports
 *
 * This class is responsible for generating and sending reports via email.
 *
 * @package AIDFW_Plugin\Business
 */
	AIDFW_Plugin\Business\Email_Reports;
use /**
 * A class for marking comments as spam in the admin area.
 *
 * This class provides functionality to mark comments as spam in the WordPress admin area.
 * It utilizes the WordPress comment functions to update the comment status.
 *
 * @package AIDFW_Plugin
 * @subpackage Admin
 */
	AIDFW_Plugin\Admin\Mark_Spam;

/**
 * Core class
 *
 * This class represents the core functionality of the application.
 * It sets up options data, defines settings pages, and defines admin hooks.
 *
 * @package YourPackageName
 */
class Core {
	public function __construct(  ) {
	}

	/**
	 *
	 */
	public function run() {
		$this->set_options_data();
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
	private function settings_pages() {
		$settings = new Admin_Settings();
		add_action( 'admin_menu', array( $settings, 'settings_setup' ) );
		add_action( 'init', array( $settings, 'plugin_action_links' ) );
	}

	/**
	 *
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Admin();
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_styles' ) );
		add_action( 'woocommerce_before_product_object_save', array( $plugin_admin,'on_product_save'), 10, 1 );
	}

}
