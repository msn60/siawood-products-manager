<?php
/**
 * WC_Setting_Tab_Manager abstract Class File
 *
 * This file contains contract for creating settings tab in woocommerce setting page
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Siawood_Products\Includes\Abstracts;

use Siawood_Products\Includes\Interfaces\Action_Hook_Interface;
use Siawood_Products\Includes\Interfaces\Filter_Hook_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Setting_Tab_Manager abstract Class File
 *
 * This file contains contract for creating settings tab in woocommerce setting page
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @link       https://wpwebmaster.ir
 *
 * @see        https://www.speakinginbytes.com/2014/07/woocommerce-settings-tab/
 * @see        wp-content/plugins/woocommerce/includes/admin/wc-admin-functions.php & woocommerce_admin_fields() method
 * @see        wp-content/plugins/woocommerce/includes/admin/class-wc-admin-settings.php
 *
 * @see        https://docs.woocommerce.com/document/adding-a-section-to-a-settings-tab/
 * @see        https://www.tychesoftwares.com/how-to-add-custom-sections-fields-in-woocommerce-settings/
 * @see        https://stackoverflow.com/questions/54502116/add-a-custom-settings-tab-to-woocommerce-settings-for-customer-list-content
 * @see        https://www.skyverge.com/blog/post_series/build-woocommerce-extension/
 * @see        https://www.skyverge.com/blog/add-plugin-settings-to-woocommerce-part-1/
 * @see        https://gist.github.com/neo99/eec01b9df3448ee27ee6
 */
abstract class WC_Setting_Tab_Manager implements Filter_Hook_Interface {

	/**
	 * Register filter to add setting tab in Woocommerce settings
	 *
	 */
	public function register_add_filter() {
		add_filter( 'woocommerce_settings_tabs_array', [ $this, 'add_setting_tab' ], 50 );
	}

	/**
	 * Abstract method to add setting tab to settings tabs array in Woocommerce
	 *
	 * @param array $settings_tabs
	 *
	 * @return array
	 */
	abstract public function add_setting_tab( $settings_tabs );

}
