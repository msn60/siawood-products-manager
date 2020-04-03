<?php
/**
 * Current_User Class File
 *
 * This class contains functions to return current user
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Siawood_Products\Includes\Functions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Current_User Class File
 *
 * This class contains functions to return current user
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 */
trait Current_User {

	/**
	 * Add pluggable.php before it runs to get current user
	 *
	 * After using this function, you can access to all property of WP_User class like:
	 * ID
	 * user_login
	 * user_pass
	 * user_nicename
	 * user_email
	 * user_url
	 * user_registered
	 * user_activation_key
	 * user_status
	 * display_name
	 *
	 * @access  public
	 *
	 * @return \WP_User
	 */
	public function get_this_login_user() {
		include_once( ABSPATH . 'wp-includes/pluggable.php' );
		return wp_get_current_user();
	}

}