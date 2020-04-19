<?php
/**
 * Log_During_Execution Class File
 *
 * Helper method to pass arguments of Log_In_Footer during execution.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Siawood_Products\Includes\Functions;

use Siawood_Products\Includes\Interfaces\Action_Hook_With_Args_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Log_During_Execution Class File
 *
 * Helper method to pass arguments of Log_In_Footer during execution.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 */
trait Log_During_Execution {

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

}
