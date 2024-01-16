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

/**
 *
 * Plugin Name:       AI Descriptions for WooCommerce
 * Plugin URI:        https://fullworksplugins.com/products/ai-descriptions-for-woocommerce/
 * Description:       AI Descriptions for WooCommerce
 * Version:           1.0.0
 * Author:            Fullworks
 * Author URI:        https://fullworksplugins.com/
 * Requires at least: 4.9
 * Requires PHP:      5.6
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       ai-descriptions-for-woocommerce
 * Domain Path:       /languages
 *
 * @package ai-descriptions-for-woocommerce
 *
 *
 *
 */

namespace AI_Descriptions_For_WooComerce;

use \AI_Descriptions_For_WooComerce\Control\Core;
use \AI_Descriptions_For_WooComerce\Control\Freemius_Config;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'AI_Descriptions_For_WooComerce\run_AI_Descriptions_For_WooComerce' ) ) {
	define( 'AI_DESCRIPTIONS_FOR_WOOCOMMERCE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	define( 'AI_DESCRIPTIONS_FOR_WOOCOMMERCE_CONTENT_DIR', dirname( plugin_dir_path( __DIR__ ) ) );
	define( 'AI_DESCRIPTIONS_FOR_WOOCOMMERCE_PLUGINS_TOP_DIR', plugin_dir_path( __DIR__ ) );
	define( 'AI_DESCRIPTIONS_FOR_WOOCOMMERCE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
	define( 'AI_DESCRIPTIONS_FOR_WOOCOMMERCE_PLUGIN_VERSION', '1.0.0' );


	require_once AI_DESCRIPTIONS_FOR_WOOCOMMERCE_PLUGIN_DIR . 'control/autoloader.php';
	require_once AI_DESCRIPTIONS_FOR_WOOCOMMERCE_PLUGIN_DIR . 'vendor/autoload.php';

	function run_AI_Descriptions_For_WooComerce() {

		register_activation_hook( __FILE__, array( '\AI_Descriptions_For_WooComerce\Control\Activator', 'activate' ) );
		add_action( 'wpmu_new_blog', array(
			'\AI_Descriptions_For_WooComerce\Control\Activator',
			'on_create_blog_tables'
		), 10, 6 );
		register_deactivation_hook( __FILE__, array( '\AI_Descriptions_For_WooComerce\Control\Deactivator', 'deactivate' ) );
		add_filter( 'wpmu_drop_tables', array( '\AI_Descriptions_For_WooComerce\Control\Deactivator', 'on_delete_blog_tables' ) );


        register_uninstall_hook( __FILE__, array( '\AI_Descriptions_For_WooComerce\Control\Uninstaller', 'uninstall' ) );

		$plugin = new Core();
		$plugin->run();
	}


	run_AI_Descriptions_For_WooComerce();
} else {
	die( esc_html__( 'Cannot execute as the plugin already exists, if you have a another version installed deactivate that and try again', 'ai-descriptions-for-woocommerce' ) );
}

