<?php
/**
 * De-activator Class File
 *
 * This class defines tasks that must be run when plugin is deactivated.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Siawood_Products\Includes\Uninstall;

use Siawood_Products\Includes\Config\Email_Initial_Values;
use Siawood_Products\Includes\Functions\{
	Current_User, Logger, Log_In_Footer
};
use Siawood_Products\Includes\Parts\Email\Custom_Email;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Deactivator.
 * You can run desire tasks with this class when your plugin is de-activated.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 */
class Deactivator {
	use Current_User;
	use Logger;
	use Email_Initial_Values;

	/**
	 * Run related tasks when plugin is deactivated
	 *
	 * @access public
	 * @since  1.0.1
	 */
	public function deactivate( ) {
		$email_object = new Custom_Email( 'siawood_plugin_disable', $this->get_email_subjects(), $this->get_email_templates() );
		$email_object->send_email();
		// TODO: Add email log in email-logs.txt
		$this->register_deactivator_user();

	}

	/**
	 * Register user who de-activate the plugin
	 */
	public function register_deactivator_user() {

		$current_user = $this->get_this_login_user();
		$this->append_log_in_text_file(
			'The user with login of: "' . $current_user->user_login . '" and display name of: "' . $current_user->display_name
			. '" de-activated this plugin',
			SIAWOOD_PRODUCTS_LOGS . 'deactivator-logs.txt',
			'De-Activator User' );

	}

	public function send_notification_email( Custom_Email $email_object, Log_In_Footer $log_in_footer_object ) {
		$email_object->register_add_filter_with_arguments( $log_in_footer_object );
	}

}


