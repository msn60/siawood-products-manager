<?php
/**
 * Wrong_Url_Notice Class File
 *
 * This file contains admin notices to show that url is wrong (to access webservice)
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
 * Wrong_Url_Notice Class File
 *
 * This file contains admin notices to show that url is wrong (to access webservice)
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @link       https://wpwebmaster.ir
 *
 * @see        https://code.tutsplus.com/series/persisted-wordpress-admin-notices--cms-1252
 * @see        https://code.tutsplus.com/tutorials/persisted-wordpress-admin-notices-part-1--cms-30134
 */
class Wrong_Url_Notice extends Admin_Notice {


	/**
     * Method to show admin notice which is Woocommerce is not activated.
	 *
	 * @param array $args Arguments which are needed to show on notice
	 */
	public function show_admin_notice() {
		?>
        <div class="notice notice-error is-dismissible">
            <p>
				<?php _e(
					'تنظیمات URL برای وب سرویس صحیح نیست و پلاگین مدیریت موجودی کالای سیاوود، نمی تواند اجرا شود. برای اجرای آن، تنظیمات را حتما بررسی کنید و آدرس صحیح وارد کنید',
					SIAWOOD_PRODUCTS_TEXTDOMAIN
				) ?>
            </p>
        </div>

		<?php
	}

}
