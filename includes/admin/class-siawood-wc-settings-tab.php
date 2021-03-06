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

use Siawood_Products\Includes\Config\Siawood_Initial_Values;
use Siawood_Products\Includes\Functions\Template_Builder;

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
 * @see        https://www.battlestardigital.com/how-to-extend-woocommerce-with-the-wordpress-plugin-boilerplate/
 * @see        https://github.com/msn60/wordpress-plugin-boilerplate-woocommerce
 * @see        https://www.speakinginbytes.com/2014/07/woocommerce-settings-tab/
 * @see        wp-content/plugins/woocommerce/includes/admin/wc-admin-functions.php & woocommerce_admin_fields() method
 * @see        wp-content/plugins/woocommerce/includes/admin/class-wc-admin-settings.php
 *
 * @see        https://docs.woocommerce.com/document/adding-a-section-to-a-settings-tab/
 * @see        https://www.tychesoftwares.com/how-to-add-custom-sections-fields-in-woocommerce-settings/
 * @see        https://stackoverflow.com/questions/54502116/add-a-custom-settings-tab-to-woocommerce-settings-for-customer-list-content
 * @see        https://www.skyverge.com/blog/post_series/build-woocommerce-extension/
 * @see        https://www.skyverge.com/blog/add-plugin-settings-to-woocommerce-part-1/
 * @see        https://gist.github.com/neo99/eec01b9df3448ee27ee6
 *
 */
class Siawood_WC_Settings_Tab extends \WC_Settings_Page {
	use Siawood_Initial_Values;
	use Template_Builder;

	/**
	 * @var string $prefix Prefix for setting which is saved in options table
	 */
	private $prefix;

	public function __construct() {

		$this->id    = 'siawood';
		$this->label = __( 'سیاوود', SIAWOOD_PRODUCTS_TEXTDOMAIN );
		$this->prefix   = 'swdprd_';

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
		$sections = [
			''                       => __( 'تنظیمات عمومی', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
			'log'                    => __( 'گزارش ها', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
			'manual_update'          => __( 'به روز رسانی دستی', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
			'remove_extra_log_files' => __( 'پاک کردن لاگ های اضافی', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
		];

		return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
	}

	/**
	 * Output the settings
	 */
	public function output() {
		$settings = $this->get_settings();

		\WC_Admin_Settings::output_fields( $settings );
	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings() {

		global $current_section;

		$settings = [];

		switch ( $current_section ) {
			case 'log':
				//include SIAWOOD_PRODUCTS_PATH . 'templates/admin/settings-page/log-section.php';
				$this->load_template( 'settings-page.log-section' );
				break;
			case 'manual_update':
				$settings = $this->get_siawood_manual_update_settings_page_elements( $this->prefix );
				//$this->load_template( 'settings-page.manual-update-section' );
				break;
			case 'remove_extra_log_files':
				$settings = $this->get_siawood_remove_extra_logs_settings_page_elements( $this->prefix );
				//$this->load_template( 'settings-page.manual-update-section' );
				break;
			default:
				$settings = $this->get_siawood_general_settings_page_elements( $this->prefix );
		}

		return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings, $current_section );
	}

	/**
	 * Save settings
	 *
	 * @since 1.0
	 */
	public function save() {
		/*global $current_tab;
		var_dump($current_tab);*/
		// TODO: admin notice must show after integration settings save
		//https://github.com/woocommerce/woocommerce/issues/16221

		$settings = $this->get_settings();

		\WC_Admin_Settings::save_fields( $settings );
	}

}

new Siawood_WC_Settings_Tab();

