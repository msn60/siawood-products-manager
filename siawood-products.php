<?php
/**
 * Siawood Products Manager
 *
 * A plugin to manage Siawood products
 *
 * @link              https://wpwebmaster.ir
 * @since             1.0.0
 * @package           Siawood_Products
 *
 * @wordpress-plugin
 * Plugin Name:       Siawood Products Manager
 * Plugin URI:        https://wpwebmaster.ir
 * Description:       A plugin to manage Siawood products
 * Version:           1.0.1
 * Author:            Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * Author URI:        https://wpwebmaster.ir
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

/*
 * Define your namespaces here by use keyword
 * */

use Siawood_Products\Includes\Init\{
	Admin_Hook, Core, Constant, Activator, I18n
};
use Siawood_Products\Includes\Config\Initial_Value;
use Siawood_Products\Includes\Parts\Other\Remove_Post_Column;
use Siawood_Products\Includes\Uninstall\{
	Deactivator, Uninstall
};
use Siawood_Products\Includes\Admin\Notices\{
	Woocommerce_Deactive_Notice, Wrong_Url_Notice
};

use Siawood_Products\Includes\Functions\Init_Functions;
use Siawood_Products\Includes\Parts\Shortcodes\Complete_Shortcode;
use Siawood_Products\Includes\Parts\Products\Products_Updater;
use Siawood_Products\Includes\Parts\Email\Custom_Email;
use Siawood_Products\Includes\Hooks\Filters\Custom_Cron_Schedule;

/**
 * If this file is called directly, then abort execution.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Siawood_Products_Plugin
 *
 * This class is primary file of plugin which is used from
 * singletone design pattern.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @see        Siawood_Products\Includes\Init\Core Class
 * @see        Siawood_Products\Includes\Init\Constant Class
 * @see        Siawood_Products\Includes\Init\Activator Class
 * @see        Siawood_Products\Includes\Uninstall\Deactivator Class
 * @see        Siawood_Products\Includes\Uninstall\Uninstall Class
 */
final class Siawood_Products_Plugin {
	/**
	 * Instance property of Siawood_Products_Plugin Class.
	 * This is a property in your plugin primary class. You will use to create
	 * one object from Siawood_Products_Plugin class in whole of program execution.
	 *
	 * @access private
	 * @var    Siawood_Products_Plugin $instance create only one instance from plugin primary class
	 * @static
	 */
	private static $instance;
	/**
	 * @var Initial_Value $initial_values An object  to keep all of initial values for theme
	 */
	protected $initial_values;
	/**
	 * @var Core $core_object An object to keep core class for plugin.
	 */
	private $core_object;

	/**
	 * Siawood_Products_Plugin constructor.
	 * It defines related constant, include autoloader class, register activation hook,
	 * deactivation hook and uninstall hook and call Core class to run dependencies for plugin
	 *
	 * @access private
	 */
	public function __construct() {
		/*Define Autoloader class for plugin*/
		$autoloader_path = 'includes/class-autoloader.php';
		/**
		 * Include autoloader class to load all of classes inside this plugin
		 */
		require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . $autoloader_path;
		/*Define required constant for plugin*/
		Constant::define_constant();

		/**
		 * Register activation hook.
		 * Register activation hook for this plugin by invoking activate
		 * in Siawood_Products_Plugin class.
		 *
		 * @param string   $file     path to the plugin file.
		 * @param callback $function The function to be run when the plugin is activated.
		 */
		register_activation_hook(
			__FILE__,
			function () {
				$this->activate(
					new Activator( intval( get_option( 'last_plugin_name_dbs_version' ) ) )
				);
			}
		);
		/**
		 * Register deactivation hook.
		 * Register deactivation hook for this plugin by invoking deactivate
		 * in Siawood_Products_Plugin class.
		 *
		 * @param string   $file     path to the plugin file.
		 * @param callback $function The function to be run when the plugin is deactivated.
		 */
		register_deactivation_hook(
			__FILE__,
			function () {
				$this->deactivate(
					new Deactivator()
				);
			}
		);
		/**
		 * Register uninstall hook.
		 * Register uninstall hook for this plugin by invoking uninstall
		 * in Siawood_Products_Plugin class.
		 *
		 * @param string   $file     path to the plugin file.
		 * @param callback $function The function to be run when the plugin is uninstalled.
		 */
		register_uninstall_hook(
			__FILE__,
			array( 'Siawood_Products_Plugin', 'uninstall' )
		);
	}

	/**
	 * Call activate method.
	 * This function calls activate method from Activator class.
	 * You can use from this method to run every thing you need when plugin is activated.
	 *
	 * @access public
	 * @since  1.0.0
	 * @see    Siawood_Products\Includes\Init\Activator Class
	 */
	public function activate( Activator $activator_object ) {
		$activator_object->activate();
	}

	/**
	 * Call deactivate method.
	 * This function calls deactivate method from Dectivator class.
	 * You can use from this method to run every thing you need when plugin is deactivated.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function deactivate( Deactivator $deactivator_object ) {
		$deactivator_object->deactivate();
	}

	/**
	 * Create an instance from Siawood_Products_Plugin class.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return Siawood_Products_Plugin
	 */
	public static function instance() {
		if ( is_null( ( self::$instance ) ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Call uninstall method.
	 * This function calls uninstall method from Uninstall class.
	 * You can use from this method to run every thing you need when plugin is uninstalled.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public static function uninstall() {
		Uninstall::uninstall();
	}

	/**
	 * Load Core plugin class.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function run_siawood_products_plugin() {
		$this->initial_values = new Initial_Value();
		$this->core_object    = new Core(
			$this->initial_values,
			/*new Custom_Cron_Schedule( $this->initial_values->sample_custom_cron_schedule() ),
			new Init_Functions(),
			new I18n(),*/
			new Admin_Hook( SIAWOOD_PRODUCTS_PLUGIN, SIAWOOD_PRODUCTS_VERSION ),
			new Products_Updater(),
			[
				new Complete_Shortcode( $this->initial_values->sample_complete_shortcode() ),
			],
			[
				'woocommerce_deactivate_notice' => new Woocommerce_Deactive_Notice(),
				'wrong_url_notice'              => new Wrong_Url_Notice(),
			]

		);
		$this->core_object->init_core();
	}
}


$siawood_products_plugin_object = Siawood_Products_Plugin::instance();
$siawood_products_plugin_object->run_siawood_products_plugin();