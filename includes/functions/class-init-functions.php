<?php
/**
 * Init_Functions Class File
 *
 * This file contains a class that handle all of initial functions or methods
 * that you need alongside of your plugin.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.0
 */

namespace Siawood_Products\Includes\Functions;

use Siawood_Products\Includes\Interfaces\Action_Hook_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Init_Functions.
 * This class handle all of initial functions or methods
 * that you need alongside of your plugin.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 */
class Init_Functions implements Action_Hook_Interface {

	/**
	 * Method app_output_buffer in Init_Functions Class
	 *
	 * This function will turn output buffering on. While output buffering
	 * is active no output is sent from the script (other than headers),
	 * instead the output is stored in an internal buffer.
	 *
	 * @access  public
	 * @static
	 * @see     http://php.net/manual/en/function.ob-start.php
	 * @see     https://wpshout.com/php-output-buffering/
	 */
	public function app_output_buffer() {
		ob_start();
	}

	/**
	 * Method not_access_to_wp_admin_panel in Init_Functions Class
	 *
	 * This method checks to avoid access of some caps to admin panel
	 *
	 * @access  public
	 * @see     https://alka-web.com/blog/how-to-restrict-access-to-wordpress-dashboard-programmatically/
	 */
	public function not_access_to_wp_admin_panel() {
		if ( is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) && ( current_user_can( 'your_custom_cap' ) ) ) {
			wp_safe_redirect( home_url(), 302 );
			exit;
		}
	}


	/**
	 * Method remove_admin_bar in Init_Functions Class
	 *
	 * This method removes admin bar in front end.
	 *
	 * @access  public
	 */
	public function remove_admin_bar() {
		if ( current_user_can( 'your_custom_cap' ) ) {
			show_admin_bar( false );
		}
	}

	/**
	 * Register actions that the object needs to be subscribed to.
	 *
	 */
	public function register_add_action() {
		add_action( 'init', array( $this, 'app_output_buffer' ) );
	}
}
