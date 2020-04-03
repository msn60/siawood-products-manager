<?php
/**
 * Uninstall Class
 *
 * This class defines tasks that must be run when plugin uninstalling.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.0
 */

namespace Siawood_Products\Includes\Uninstall;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Uninstall
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 */
class Uninstall {
	/**
	 * Destroy Config
	 * Drop Database
	 * Delete options
	 */
	public static function uninstall() {

		// TODO: delete_option for option values that need them again
		// TODO: delete_option for post types ('has_rewrite_for_plugin_name_new_post_types')

	}
}



