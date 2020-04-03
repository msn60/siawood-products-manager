<?php
/**
 * Activator Class File
 *
 * This file contains Activator class. If you want to perform some actions
 * in activating of your plugin, you can add your desire methods to it.
 * Actions likes installing separated tables (except WordPress tables),
 * initializing configs for plugin and using update_option, can do with this class.
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

use Siawood_Products\Includes\Config\Info;
use Siawood_Products\Includes\Functions\{
	Check_Type, Logger, Current_User
};

/**
 * Class Activator.
 * If you want to perform some actions in activating of your plugin, you can add your desire methods to it.
 * Actions likes installing separated tables (except WordPress tables),
 * initializing configs for plugin and using update_option, can do with this class.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @see        \Siawood_Products\Includes\Config\Info
 * @see        \Siawood_Products\Includes\Database\Table
 */
class Activator {
	use Logger;
	use Check_Type;
	use Current_User;
	/**
	 * @var int $last_db_version The last version of your plugin database
	 */
	private $last_db_version;

	/**
	 * Activator constructor.
	 */
	public function __construct( $last_db_version = null ) {
		$this->last_db_version = $last_db_version;
	}

	/**
	 * Method activate in Activator Class
	 *
	 * It calls when plugin is activated.
	 *
	 * @access  public
	 * @static
	 */
	public function activate(
		$is_need_table_modification = false
	) {

		$this->register_activator_user();
		// Initialize plugin settings and info in option table.
		// TODO: separate this part to another method and then call it
		//Info::add_info_in_plugin_activation();
		//TODO: Show customized messages when plugin is activated


	}

	/**
	 * Register user who activate the plugin
	 */
	public function register_activator_user() {

		$current_user = $this->get_this_login_user();
		$this->append_log_in_text_file(
			'The user with login of: "' . $current_user->user_login . '" and display name of: "' . $current_user->display_name
			. '" activated this plugin',
			SIAWOOD_PRODUCTS_LOGS . 'activator-logs.txt',
			'Activator User' );

	}

}

