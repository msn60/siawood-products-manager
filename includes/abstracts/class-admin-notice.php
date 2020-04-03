<?php
/**
 * Admin_Notice abstract Class File
 *
 * This file contains contract for Admin_Notice class.
 * If you want to create a Admin_Notice, you must use from this contract.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Siawood_Products\Includes\Abstracts;


use Siawood_Products\Includes\Functions\Utility;
use Siawood_Products\Includes\Interfaces\Action_Hook_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin_Notice abstract Class File
 *
 * This file contains contract for Admin_Notice class.
 * If you want to create a Admin_Notice, you must use from this contract.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @link       https://wpwebmaster.ir
 *
 * @see        https://code.tutsplus.com/series/persisted-wordpress-admin-notices--cms-1252
 * @see        https://code.tutsplus.com/tutorials/persisted-wordpress-admin-notices-part-1--cms-30134
 */
abstract class Admin_Notice implements Action_Hook_Interface {
	use Utility;

	/**
	 * call 'admin_notice' add_action to show notice on admin panel
	 *
	 * @access public
	 */
	public function register_add_action() {
		add_action( 'admin_notices', [$this , 'show_admin_notice'] );
	}


	/**
	 * Abstract Method show admin notice
	 *
	 * For each each defined notice, you must generate it
	 *
	 * @param array $args Arguments which are needed to show on notice
	 */
	abstract public function show_admin_notice();

}
