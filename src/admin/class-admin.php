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

/**
 * The admin-specific functionality of the plugin.
 *
 *
 */

namespace AIDFW_Plugin\Admin;

use Orhanerday\OpenAi\OpenAi;

/**
 * Class Admin
 * @package AIDFW_Plugin\Admin
 */
class Admin {

	public function __construct() {
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 */
	public function enqueue_styles() {
		wp_enqueue_style( AIDFW_PLUGIN_BASENAME, plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), AIDFW_PLUGIN_VERSION, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( AIDFW_PLUGIN_BASENAME, plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), AIDFW_PLUGIN_VERSION, false );
	}

	public function on_product_save( $product ) {
		if ( ! empty( $product->get_description() ) ) {
			return;
		}
		$options  = get_option( 'ai-descriptions-for-woocommerce' );
		$openai   = new Openai( $options['openai_api_key'] );
		$complete = $openai->completion(
			array(
				'model'       => 'text-davinci-003',
				'prompt'      => 'write a long product description based on this product name - ' . $product->get_name() . '\n\n###\n\n',
				'max_tokens'  => 1000,
				'temperature' => 0.8,
				'n'           => 2,
			)
		);
		$data     = json_decode( $complete );
		if ( property_exists( $data, 'error' ) ) {
			// handle error
			return;
		}
		// update woocommerce description data
		$desc = '';
		foreach ( $data->choices as $choice ) {
			$desc .= $choice->text;
			if ( next( $data->choices ) ) {
				$desc .= '<p>-------------ALTERNATIVES ----------------</p>';
			}
		}
		$product->set_description( $desc );
	}
}
