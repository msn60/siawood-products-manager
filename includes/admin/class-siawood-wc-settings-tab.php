<?php
/**
 * WC_Siawood_Setting_Tab Class File
 *
 * This file creates admin setting tab for this plugin
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Siawood_Products\Includes\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Siawood_Setting_Tab Class File
 *
 * This file creates admin setting tab for this plugin
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @link       https://wpwebmaster.ir
 *
 */
class Siawood_WC_Settings_Tab extends \WC_Settings_Page {


	public function __construct() {

		$this->id    = 'siawood';
		$this->label = __( 'سیاوود', SIAWOOD_PRODUCTS_TEXTDOMAIN );

		// Define all hooks instead of inheriting from parent
		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
		add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );
		add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );

	}


	/**
	 * Get sections.
	 *
	 * @return array
	 */
	public function get_sections() {
		$sections = array(
			''    => __( 'تنظیمات عمومی', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
			'log' => __( 'گزارش ها', SIAWOOD_PRODUCTS_TEXTDOMAIN )
		);

		return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
	}


	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings() {

		global $current_section;
		$prefix = 'msn_siawood';

		switch ( $current_section ) {
			case 'log':
				$settings = array(
					array()
				);
				break;
			default:
				$settings = array(
					array()
				);
		}

		return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings, $current_section );
	}

	/**
	 * Output the settings
	 */
	public function output() {
		$settings = $this->get_settings();

		\WC_Admin_Settings::output_fields( $settings );
	}

	/**
	 * Save settings
	 *
	 * @since 1.0
	 */
	public function save() {
		$settings = $this->get_settings();

		\WC_Admin_Settings::save_fields( $settings );
	}


}

new Siawood_WC_Settings_Tab();

