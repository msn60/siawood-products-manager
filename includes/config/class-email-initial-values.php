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
			'woocommerce_disable'          => __( 'Warning for Disabling Woocommerce in Your site', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
			'webservice_wrong_ip'          => __( 'Warning for Problem with PALIZ webservice IP address', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
			'webservice_is_not_accessible' => __( 'Warning for accessing PALIZ webservice', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
			'successful_stock_update'      => __( 'Product is successfully updated in your site', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
		];

		return $subjects;
	}

	public function get_email_templates( $arg = null ) {

		$templates = [
			'woocommerce_disable'          => [
				'template' => 'email.woocommerce-disable',
				'params'   => [],
				'type'     => 'front',
			],
			'webservice_wrong_ip'          => __( 'Warning for Problem with PALIZ webservice IP address', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
			'webservice_is_not_accessible' => __( 'Warning for accessing PALIZ webservice', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
			'successful_stock_update'      => __( 'Product is successfully updated in your site', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
		];

		return $templates;
	}
}
