<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.0
 */

namespace Siawood_Products\Includes\Init;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Siawood_Products\Includes\Abstracts\{
	Admin_Notice, Shortcode
};

use Siawood_Products\Includes\Hooks\Filters\Custom_Cron_Schedule;
use Siawood_Products\Includes\Interfaces\{
	Action_Hook_Interface, Filter_Hook_Interface
};
use Siawood_Products\Includes\Config\Initial_Value;
use Siawood_Products\Includes\Functions\{
	Init_Functions, Logger, Utility, Check_Type, Web_Service
};

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.1
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 */
class Core implements Action_Hook_Interface, Filter_Hook_Interface {
	use Utility;
	use Check_Type;
	use Web_Service;
	use Logger;
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $plugin_version;

	/**
	 * @var Admin_Hook $admin_hooks Object  to keep all of hooks in your plugin
	 */
	protected $admin_hooks;

	/**
	 * @var Shortcode[] $shortcodes
	 */
	protected $shortcodes;

	/**
	 * @var Initial_Value $initial_values An object  to keep all of initial values for plugin
	 */
	protected $initial_values;

	/**
	 * @var Admin_Notice[] $admin_notices
	 */
	protected $admin_notices;

	/**
	 * @var Custom_Cron_Schedule $custom_cron_schedule
	 */
	protected $custom_cron_schedule;

	/**
	 * @var Init_Functions $init_functions Object  to keep all initial function in plugin
	 */
	protected $init_functions;
	/**
	 * @var I18n $plugin_i18n Object  to add text domain for plugin
	 */
	protected $plugin_i18n;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct(
		Initial_Value $initial_values,
		Custom_Cron_Schedule $custom_cron_schedule = null,
		Init_Functions $init_functions = null,
		I18n $plugin_i18n = null,
		Admin_Hook $admin_hooks = null,
		array $shortcodes = null,
		array $admin_notices = null

	) {
		if ( defined( 'SIAWOOD_PRODUCTS_VERSION' ) ) {
			$this->plugin_version = SIAWOOD_PRODUCTS_VERSION;
		} else {
			$this->plugin_version = '1.0.0';
		}
		if ( defined( 'SIAWOOD_PRODUCTS_PLUGIN' ) ) {
			$this->plugin_name = SIAWOOD_PRODUCTS_PLUGIN;
		} else {
			$this->plugin_name = 'siawood-products';
		}

		$this->initial_values = $initial_values;

		if ( ! is_null( $init_functions ) ) {
			$this->init_functions = $init_functions;
		}

		if ( ! is_null( $plugin_i18n ) ) {
			$this->plugin_i18n = $plugin_i18n;
		}

		if ( ! is_null( $admin_hooks ) ) {
			$this->admin_hooks = $admin_hooks;
		}

		if ( ! is_null( $custom_cron_schedule ) ) {
			$this->custom_cron_schedule = $custom_cron_schedule;
		}

		if ( ! is_null( $shortcodes ) ) {
			$this->shortcodes = $this->check_array_by_parent_type( $shortcodes, Shortcode::class )['valid'];;
		}
		if ( ! is_null( $admin_notices ) ) {
			$this->admin_notices = $this->check_array_by_parent_type( $admin_notices, Admin_Notice::class )['valid'];;
		}

	}


	/**
	 * Run the Needed methods for plugin
	 *
	 * In run method, you can run every methods that you need to run every time that your plugin is loaded.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function init_core() {
		$this->register_add_action();
		$this->register_add_filter();
		$this->set_shortcodes();
		$this->show_admin_notice();

	}

	/**
	 * Register all needed add_actions for this plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 *
	 */
	public function register_add_action() {
		if ( ! is_null( $this->init_functions ) ) {
			$this->init_functions->register_add_action();
		}
		if ( ! is_null( $this->plugin_i18n ) ) {
			$this->plugin_i18n->register_add_action();
		}

		/*if ( is_admin() ) {

		}*/
	}

	/**
	 * Register filters that the object needs to be subscribed to.
	 *
	 */
	public function register_add_filter() {
		$this->custom_cron_schedule->register_add_filter();
	}

	/**
	 * Method to set all of needed shortcodes for your plugin
	 *
	 * @access private
	 * @since  1.0.1
	 */
	private function set_shortcodes() {
		if ( ! is_null( $this->shortcodes ) ) {
			foreach ( $this->shortcodes as $shortcode ) {
				$shortcode->register_add_action();
			}
		}
	}

	/**
	 * Method to show all of needed admin notice in admin panel
	 *
	 * @access private
	 * @since  1.0.1
	 */
	private function show_admin_notice() {
		if ( ! is_null( $this->admin_notices ) ) {
			foreach ( $this->admin_notices as $admin_notice ) {
				$admin_notice->register_add_action();
			}
		}
	}

	public function ghanbar() {

		$fp            = fopen( SIAWOOD_PRODUCTS_LOGS . 'list-of-products.txt', 'a' );//opens file in append mode
		$count         = 0;
		$gholam_string = '';


		$results = $this->get_webservice_data( 'http://94.139.176.25:890/api/stock' );
		foreach ( $results['product_items'] as $item ) {
			$count ++;
			//echo 'SKU: ' . $item['sku'] . ' and stock: ' . $item['stock']. '<br>';
			$gholam_string .= 'SKU: ' . $item['sku'] . ' and stock: ' . $item['stock'] . PHP_EOL;
			/*$this->append_log_in_text_file(
				'SKU: ' . $item['sku'] . ' and stock: ' . $item['stock'],
				SIAWOOD_PRODUCTS_LOGS . 'list-of-products.txt', 'ghanbar' );*/
		}
		fwrite( $fp, $gholam_string );

		fwrite( $fp, 'count: ' . $count . PHP_EOL );
		fclose( $fp );
		/*var_dump( $results['count'] );
		var_dump( $results['product_items']['sku'] );*/
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->plugin_version;
	}

}

