<?php
/**
 * Woocommerce_Deactive_Notice Class File
 *
 * This file contains admin notices to show that Woocommerce is deactivated in admin panel
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
 * Woocommerce_Deactive_Notice Class File
 *
 * This file contains admin notices to show that Woocommerce is deactivated in admin panel
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @link       https://wpwebmaster.ir
 *
 * @see        https://code.tutsplus.com/series/persisted-wordpress-admin-notices--cms-1252
 * @see        https://code.tutsplus.com/tutorials/persisted-wordpress-admin-notices-part-1--cms-30134
 */
class Woocommerce_Deactive_Notice extends Admin_Notice {


	/**
     * Method to show admin notice which is Woocommerce is not activated.
	 *
	 * @param array $args Arguments which are needed to show on notice
	 */
	public function show_admin_notice() {
		?>
        <div class="notice notice-error">
            <p>
				<?php _e(
					'متاسفانه پلاگین ووکامرس فعال نیست. به همین دلیل موجودی اجناس در سایت نمی تواند آپدیت شود. برای استفاده از پلاگین، حتما ووکامرس را فعال نمایید',
					SIAWOOD_PRODUCTS_TEXTDOMAIN
				) ?>
            </p>
        </div>

		<?php
	}

}
