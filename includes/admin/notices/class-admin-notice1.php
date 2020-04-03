<?php
/**
 * Admin_Notice1 abstract Class File
 *
 * This file contains sample admin notices in admin panel based on logic conditions
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Siawood_Products\Includes\Admin\Notices;


use Siawood_Products\Includes\Abstracts\Admin_Notice;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin_Notice1 abstract Class File
 *
 * This file contains contract for Admin_Notice1 class.
 * If you want to create a Admin_Notice1, you must use from this contract.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @link       https://wpwebmaster.ir
 *
 * @see        https://code.tutsplus.com/series/persisted-wordpress-admin-notices--cms-1252
 * @see        https://code.tutsplus.com/tutorials/persisted-wordpress-admin-notices-part-1--cms-30134
 */
class Admin_Notice1 extends Admin_Notice {


	/**
	 * Abstract Method show admin notice
	 *
	 * For each each defined notice, you must generate it
	 *
	 * @param array $args Arguments which are needed to show on notice
	 */
	public function show_admin_notice() {

		$actual_link = ( 'on' === isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] ? 'https' : 'http' )
		               . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		if ( preg_match( '/siawood-products-option-page-url-2/', $actual_link ) ) {
			?>
            <div class="notice notice-success"><p>Sample of Admin success notice</p></div>
            <div class="notice notice-warning"><p>Sample of Admin warning notice</p></div>
            <div class="notice notice-info"><p>Sample of Admin info notice</p></div>
            <div class="notice notice-error"><p>Sample of Admin error notice</p></div>

			<?php
		}
		/*var_dump( get_current_screen() );
		var_dump( $_SERVER['HTTP_HOST'] );
		var_dump( $_SERVER['REQUEST_URI'] );
		$site_url = get_site_url();
		$temp_url = str_replace( $site_url, '', $actual_link );
		var_dump( $actual_link );*/

	}

}
