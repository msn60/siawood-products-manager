<?php
/**
 * Email_Initial_Values Class File
 *
 * Initial values for sending Email
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Siawood_Products\Includes\Config;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Email_Initial_Values.
 * Initial values for sending Email
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 */
trait Email_Initial_Values {

	/**
	 * @param array \ null $args To create dynamic arguments for subjects
	 *
	 * @return array
	 */
	public function get_email_subjects( $arg = null ) {

		$subjects = [
			'siawood_plugin_disable'       => __( 'پیام هشدار برای فعال نبودن پلاگین سیاوود سیاوود', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
			'woocommerce_disable'          => __( 'پیام هشدار برای فعال نبودن ووکامرس در سایت سیاوود', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
			'webservice_wrong_ip'          => __( 'پیام هشدار برای اشتباه بودن آدرس وب سرویس پالیز', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
			'webservice_is_not_accessible' => __( 'پیام هشدار برای در دسترس نبودن وب سرویس پالیز', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
			'successful_stock_update'      => __( 'پیام برای آپدیت شدن موجودی انبار سایت سیاوود', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
		];

		return $subjects;
	}

	public function get_email_templates( $arg = null ) {

		$templates = [
			'siawood_plugin_disable'       => [
				'template' => 'email.siawood-plugin-disable',
				'params'   => [],
				'type'     => 'front',
			],
			'woocommerce_disable'          => [
				'template' => 'email.woocommerce-disable',
				'params'   => [],
				'type'     => 'front',
			],
			'webservice_is_not_accessible' => [
				'template' => 'email.webservice-issues',
				'params'   => [],
				'type'     => 'front',
			],
			'webservice_wrong_ip'          => [
				'template' => 'email.webservice-wrong-ip',
				'params'   => [],
				'type'     => 'front',
			],
			'successful_stock_update'          => [
				'template' => 'email.product-update',
				'params'   => [],
				'type'     => 'front',
			],
		];

		return $templates;
	}
}
