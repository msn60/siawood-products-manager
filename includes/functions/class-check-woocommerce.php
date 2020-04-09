<?php
/**
 * Check_Woocommerce trait File
 *
 * This class contains methods that check is woocommerce activated or not
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
 * Check_Woocommerce trait File
 *
 * This class contains methods that check is woocommerce activated or not
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @since      1.0.1
 */
trait Check_Woocommerce {

	/**
	 * Method to check is Woocommerce activated or not
	 *
	 *
	 * @access  public
	 *
	 * @return bool
	 */
	public function is_woocommerce_active( ) {
		if ( in_array('woocommerce/woocommerce.php', apply_filters('siawood_active_plugins',get_option('active_plugins')))) {
			return true;
		} else {
			return false;
		}
	}

}
