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

use Siawood_Products\Includes\Abstracts\Admin_Notice;

use Siawood_Products\Includes\Config\Email_Initial_Values;
use Siawood_Products\Includes\Hooks\Filters\Custom_Cron_Schedule;
use Siawood_Products\Includes\Interfaces\{
	Action_Hook_Interface, Filter_Hook_Interface
};
use Siawood_Products\Includes\Config\Initial_Value;
use Siawood_Products\Includes\Functions\{Check_Woocommerce,
	File_End_Reader,
	File_Remove_From_Specific_Time,
	Init_Functions,
	Logger,
	Url_Checker,
	Utility,
	Check_Type,
	Web_Service,
	Log_In_Footer
};

use Siawood_Products\Includes\Parts\Email\Custom_Email;
use Siawood_Products\Includes\Parts\Products\Products_Updater;


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
	use Check_Woocommerce;
	use Utility;
	use Check_Type;
	use Web_Service;
	use Logger;
	use Url_Checker;
	use Email_Initial_Values;
	use File_End_Reader;
	use File_Remove_From_Specific_Time;

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
	 * @var Products_Updater $products_updater Object  to keep product updater class
	 */
	protected $products_updater;

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
	 * @var Log_In_Footer $log_in_footer Object  to write log message
	 */
	protected $log_in_footer;

	/**
	 * @var string $writing_log_status_for_woo_disabling Options to keep status of state of writing log when woocommerce is disabled.
	 */
	protected $writing_log_status_for_woo_disabling;

	/**
	 * @var string $writing_log_status_for_woo_disabling Options to keep status of state of writing log when url is wrong.
	 */
	protected $writing_log_status_for_wrong_url;

	/**
	 * @var string $webservice_address Webservice address to get stocks amounts from third party service
	 */
	protected $webservice_address;

	/**
	 * @var string $writing_log_status_for_webservice_issues Options to keep status of state of writing log when has webservice issues.
	 */
	protected $writing_log_status_for_webservice_issues;
	/**
	 * @var array $last_update Array of last update date and time
	 */
	protected $last_update;
	/**
	 * @var array $now_date_time Array of current date and time when plugin run
	 */
	protected $now_date_time;
	/**
	 * @var array $webservice_data Array of mixed content from webservice status and data
	 */
	protected $webservice_data;
	/**
	 * @var bool $is_need_manual_update
	 */
	protected $is_need_manual_update;
	/**
	 * @var bool $only_update_manually Options to detect do you need automatically update or not
	 */
	protected $only_update_manually;
	/**
	 * @var bool $is_need_remove_extra_update_success_logs To remove extra log files for list of success and fail products
	 */
	protected $is_need_remove_extra_update_success_logs;
	/**
	 * @var bool $is_need_archive_log_files To archive log files and remove them more than 3 months
	 */
	protected $is_need_archive_log_files;

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
		/*Custom_Cron_Schedule $custom_cron_schedule = null,
		Init_Functions $init_functions = null,
		I18n $plugin_i18n = null,*/
		Admin_Hook $admin_hooks,
		Products_Updater $products_updater,
		array $admin_notices = null

	) {
		if ( defined( 'SIAWOOD_PRODUCTS_VERSION' ) ) {
			$this->plugin_version = SIAWOOD_PRODUCTS_VERSION;
		} else {
			$this->plugin_version = '1.2.0';
		}
		if ( defined( 'SIAWOOD_PRODUCTS_PLUGIN' ) ) {
			$this->plugin_name = SIAWOOD_PRODUCTS_PLUGIN;
		} else {
			$this->plugin_name = 'siawood-products';
		}

		$this->initial_values = $initial_values;

		if ( ! is_null( $admin_hooks ) ) {
			$this->admin_hooks = $admin_hooks;
		}

		if ( ! is_null( $products_updater ) ) {
			$this->products_updater = $products_updater;
		}

		/*if ( ! is_null( $custom_cron_schedule ) ) {
			$this->custom_cron_schedule = $custom_cron_schedule;
		}*/

		if ( ! is_null( $admin_notices ) ) {
			$this->admin_notices = $this->check_array_by_parent_type_assoc( $admin_notices, Admin_Notice::class )['valid'];;
		}

		$this->writing_log_status_for_woo_disabling = get_option( 'swdprd_has_log_for_deactivating_woocommerce' );
		if ( isset( $_POST ) && ! empty( $_POST ) ) {
			if ( isset( $_POST['swdprd_is_need_update_stock_manually'] ) && '1' === $_POST['swdprd_is_need_update_stock_manually'] ) {
				$this->is_need_manual_update = true;
			} else {
				$this->is_need_manual_update = false;
			}

			if ( isset( $_POST['swdprd_is_need_remove_extra_update_success_logs'] )
			     && '1' === $_POST['swdprd_is_need_remove_extra_update_success_logs']
			) {
				$this->is_need_remove_extra_update_success_logs = true;
			} else {
				$this->is_need_remove_extra_update_success_logs = false;
			}

			if ( isset( $_POST['swdprd_is_need_archive_large_files'] )
			     && '1' === $_POST['swdprd_is_need_archive_large_files']
			) {
				$this->is_need_archive_log_files = true;
			} else {
				$this->is_need_archive_log_files = false;
			}
		} else {
			$this->is_need_manual_update                    = false;
			$this->is_need_remove_extra_update_success_logs = false;
			$this->is_need_archive_log_files                = false;
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
		if ( $this->is_woocommerce_active( $this->writing_log_status_for_woo_disabling ) ) {
			$this->register_add_action();
			$this->register_add_filter();
			$this->start_updater_tasks();
		} else {

			$this->set_tasks_when_woo_is_disable( new Log_In_Footer() );

		}

		if ( $this->is_need_remove_extra_update_success_logs ) {
			$this->remove_extra_update_success_fail_logs();
		}

		if ( $this->is_need_archive_log_files ) {
			$this->archive_log_files();
		}
	}

	/**
	 * Remove Extra files for list of success and fail products in update process
	 */
	protected function remove_extra_update_success_fail_logs() {
		$path = SIAWOOD_PRODUCTS_LOGS . 'product-items/';
		$time = 60 * 60 * 24 * 14;
		$this->remove_extra_files_from_time( $path, $time );
	}

	/**
	 * Archive log files larger than 200Kb & remove them more than 3 month
	 */
	protected function archive_log_files() {
		/**
		 * archive section
		 */
		$files = glob( SIAWOOD_PRODUCTS_LOGS . "*" );
		foreach ( $files as $file ) {
			if ( is_file( $file ) && ( filesize( $file ) / 1024 > 200 ) ) {
				$new_file_name = pathinfo( $file )['filename'] . '-' . date( 'Y-m-d_H-i' ) . '.txt';
				copy( $file, SIAWOOD_PRODUCTS_LOGS . 'archived-log-files/' . $new_file_name );
				fclose( fopen( $file, 'w' ) );

			}
		}
		/**
		 * Remove section
		 */
		$path = SIAWOOD_PRODUCTS_LOGS . 'archived-log-files/';
		$time = 60 * 60 * 24 * 90;
		$this->remove_extra_files_from_time( $path, $time );

	}

	/**
	 * Register all needed add_actions for this plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 *
	 */
	public function register_add_action() {
		if ( ! is_null( $this->admin_hooks ) ) {
			$this->admin_hooks->register_add_action();
		}
		//add_action( 'woocommerce_settings_page_init', [ $this, 'start_updater_tasks' ] );
	}

	/**
	 * Register filters that the object needs to be subscribed to.
	 *
	 */
	public function register_add_filter() {
		add_filter( 'woocommerce_get_settings_pages', [ $this, 'add_woocommerce_setting_page' ] );
		//$this->custom_cron_schedule->register_add_filter();
	}

	public function start_updater_tasks() {
		$this->set_needed_options();
		if ( $this->is_need_manual_update ) {
			$this->run_webservice_tasks();
		} else {
			if ( $this->check_before_start_update() && is_admin() ) {
				$this->run_webservice_tasks();
			}
		}

		/*if ( $this->check_before_start_update() ) {
			set_time_limit( 3000 );
			$this->webservice_data = $this->get_webservice_data( $this->webservice_address );
			if ( ! $this->webservice_data['connection_status'] ) {
				$this->set_tasks_when_webservice_not_accessible( new Log_In_Footer(), $this->webservice_data['error_message'] );
			} else {
				$this->run_stock_updater();
			}

		}*/
	}

	private function set_needed_options() {
		$this->writing_log_status_for_wrong_url         = get_option( 'swdprd_has_log_for_wrong_url' );
		$this->writing_log_status_for_webservice_issues = get_option( 'swdprd_has_log_for_webservice_issue' );
		$this->webservice_address                       = get_option( 'swdprd_webservice_ip_address' );
		if ( 'yes' === get_option( 'swdprd_only_update_manual' ) ) {
			$this->only_update_manually = true;
		} else {
			$this->only_update_manually = false;
		}
		date_default_timezone_set( 'Asia/Tehran' );
		$this->last_update   = get_option( 'swdprd_last_update' );
		$this->now_date_time = [
			'date' => date( 'Y-m-d' ),
			'time' => date( 'H:i:s' ),
		];
	}

	public function run_webservice_tasks() {
		set_time_limit( 3000 );
		$this->webservice_data = $this->get_webservice_data( $this->webservice_address );
		if ( ! $this->webservice_data['connection_status'] ) {
			$this->set_tasks_when_webservice_not_accessible( new Log_In_Footer(), $this->webservice_data['error_message'] );
		} else {
			$this->run_stock_updater();
		}
	}

	/**
	 * Tasks when we have webservice issues.
	 */
	private function set_tasks_when_webservice_not_accessible( Log_In_Footer $log_in_footer_object, $log_message ) {
		if ( false === $this->writing_log_status_for_webservice_issues || 'no' === $this->writing_log_status_for_webservice_issues
		     || $this->check_execution_file_end( 'Warning for problem in accessing to webservice' )
		) {
			$this->log_in_footer = $log_in_footer_object;
			$this->write_log_during_execution(
				$this->log_in_footer,
				$log_message,
				SIAWOOD_PRODUCTS_EXECUTION_LOG,
				'Warning for problem in accessing to webservice'
			);
			if ( 'yes' === get_option( 'swdprd_is_need_send_email_for_warning' ) ) {
				$notification_email = new Custom_Email( 'webservice_is_not_accessible', $this->get_email_subjects(), $this->get_email_templates() );
				$notification_email->register_add_filter_with_arguments( $this->log_in_footer, 'not accessible webservice' );
			}

			update_option( 'swdprd_has_log_for_wrong_url', 'no' );
			update_option( 'swdprd_has_log_for_webservice_issue', 'yes' );
		}

	}

	/**
	 * Check last n line  in log-execution file
	 *
	 * @return bool
	 */
	private function check_execution_file_end( $message, $line_number = 4, $file = SIAWOOD_PRODUCTS_EXECUTION_LOG ) {
		$result = $this->get_file_end( $file, $line_number );
		if ( preg_match( "/$message/", $result ) ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Method to log during plugin execution
	 *
	 * @param Log_In_Footer $log_in_footer_object Object of Log_In_Footer class
	 * @param string        $log_message          Log message that you need to write in log file
	 * @param string        $file_name            The path of log file that you need to write on
	 * @param string        $type                 Type of log file which is use in Logger trait method
	 */
	public function write_log_during_execution( Log_In_Footer $log_in_footer_object, string $log_message, string $file_name, string $type ) {
		$args                = [];
		$args['log_message'] = $log_message;
		$args['file_name']   = $file_name;
		$args['type']        = $type;
		$log_in_footer_object->register_add_action_with_arguments( $args );

	}

	/**
	 * Run updater to update stock amounts for all products in Woocommerce
	 */
	private function run_stock_updater() {

		if ( 'yes' === $this->writing_log_status_for_webservice_issues ) {
			update_option( 'swdprd_has_log_for_webservice_issue', 'no' );
		}

		$this->products_updater->set_product_items( $this->webservice_data['product_items'] );
		$this->products_updater->set_first_product_counts( $this->webservice_data['count'] );
		$this->products_updater->register_add_action();

	}

	/**
	 * Method to check needed data for update before starting update process
	 *
	 * @return bool True if all of needed parts are exist for starting update process
	 */
	private function check_before_start_update() {
		if ( ! $this->is_valid_url( $this->webservice_address ) ) {
			$this->set_tasks_when_url_wrong( new Log_In_Footer() );

			return false;
		} else {
			if ( 'yes' === $this->writing_log_status_for_wrong_url ) {
				update_option( 'swdprd_has_log_for_wrong_url', 'no' );
			}
			if (
				( strtotime( $this->now_date_time['date'] ) > strtotime( $this->last_update['date'] )
				  || $this->check_execution_file_end( $this->now_date_time['date'], 20 ) )
				&& ! $this->only_update_manually

			) {
				return true;
			}

			return false;
		}
	}

	/**
	 * Tasks which is needed if Woocommerce is not active.
	 */
	private function set_tasks_when_url_wrong( Log_In_Footer $log_in_footer_object ) {

		if ( false === $this->writing_log_status_for_wrong_url || 'no' === $this->writing_log_status_for_wrong_url
		     || $this->check_execution_file_end( 'Warning for wrong url' )
		) {
			$this->log_in_footer = $log_in_footer_object;
			$this->write_log_during_execution(
				$this->log_in_footer,
				'URL for updating stocks is wrong and you must set it in Siawood setting page again!!!',
				SIAWOOD_PRODUCTS_EXECUTION_LOG,
				'Warning for wrong url (not executing plugin process)'
			);
			$notification_email = new Custom_Email( 'webservice_wrong_ip', $this->get_email_subjects(), $this->get_email_templates() );
			$notification_email->register_add_filter_with_arguments( $this->log_in_footer, 'wrong api url' );
			update_option( 'swdprd_has_log_for_wrong_url', 'yes' );
			update_option( 'swdprd_has_log_for_webservice_issue', 'no' );

		}

		$this->admin_notices['wrong_url_notice']->register_add_action();

	}

	/**
	 * Tasks which is needed if Woocommerce is not active.
	 */
	private function set_tasks_when_woo_is_disable( Log_In_Footer $log_in_footer_object ) {

		if ( false === $this->writing_log_status_for_woo_disabling || 'no' === $this->writing_log_status_for_woo_disabling ) {
			$this->log_in_footer = $log_in_footer_object;
			$this->write_log_during_execution(
				$this->log_in_footer,
				'Woocommerce plugin is not active. Due to this reason, this plugin can not run normally!!!',
				SIAWOOD_PRODUCTS_EXECUTION_LOG,
				'Warning for not executing plugin process'
			);
			if ( 'yes' === get_option( 'swdprd_is_need_send_email_for_warning' ) ) {
				$notification_email = new Custom_Email( 'woocommerce_disable', $this->get_email_subjects(), $this->get_email_templates() );
				$notification_email->register_add_filter_with_arguments( $this->log_in_footer, 'disabling woocommerce' );
			}

			update_option( 'swdprd_has_log_for_deactivating_woocommerce', 'yes' );
		}
		$this->admin_notices['woocommerce_deactivate_notice']->register_add_action();

	}

	/**
	 * Method only for test
	 */
	public function for_testing() {
		//TODO for test
	}

	public function add_woocommerce_setting_page() {
		if ( current_user_can( 'manage_options' ) or current_user_can( 'manage_woocommerce' ) ) {
			$settings[] = include_once SIAWOOD_PRODUCTS_PATH . 'includes/admin/class-siawood-wc-settings-tab.php';

			return $settings;
		}

		return false;
	}

	public function get_product_list_from_api( $product_items, $log_in_footer_object ) {
		$count       = 0;
		$temp_string = '';
		foreach ( $product_items as $item ) {
			$count ++;
			//echo 'SKU: ' . $item['sku'] . ' and stock: ' . $item['stock']. '<br>';
			$temp_string .= 'SKU: ' . $item['sku'] . ' and stock: ' . $item['stock'] . PHP_EOL;
			/*$this->append_log_in_text_file(
				'SKU: ' . $item['sku'] . ' and stock: ' . $item['stock'],
				SIAWOOD_PRODUCTS_LOGS . 'list-of-products.txt', 'list of products' );*/
		}
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->plugin_version;
	}

	/**
	 * Check last execution date in log-execution file
	 *
	 * @return bool
	 */
	private function check_last_execution_date() {
		$result = $this->get_file_end( SIAWOOD_PRODUCTS_EXECUTION_LOG, 20 );
		$now    = $this->now_date_time['date'];
		if ( preg_match( "/$now/", $result ) ) {
			return false;
		} else {
			return true;
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

}

