<?php
/**
 * Web_ServiceClass File
 *
 * This class contains functions to return data from a web service in array format
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
 * Web_ServiceClass File
 *
 * This class contains functions to return data from a web service in array format
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 */
trait Web_Service {

	/**
	 * Return SKU and stock number from external webservice
	 *
	 *
	 * @param string $url URL to access the Webservice
	 *
	 * @return array Array of SKU and its stock amount
	 */
	public function get_webservice_data( $url ) {

		$request = wp_remote_get(
			$url,
			[
				'timeout' => 1200,
			]
		);

		if ( is_wp_error( $request ) ) {
			return [
				'connection_status' => false,
				'error_message'     => $request->get_error_message(),
			];

		}

		$body = wp_remote_retrieve_body( $request );

		$result        = json_decode( $body );
		$product_items = [];
		$count         = 0;
		foreach ( $result as $item ) {
			$product_items[] = [
				'sku'   => $item->_Barcode,
				'stock' => $item->_Stock,
			];
			$count ++;
		}

		return [
			'connection_status' => true,
			'count'             => $count,
			'product_items'     => $product_items,
		];

	}

	public function test() {
		$product_items = [
			[
				'sku'   => '1471163101142',
				'stock' => 0,
			],
			[
				'sku'   => '1471163012022',
				'stock' => 1,
			],
			[
				'sku'   => '1471163012112',
				'stock' => 2,
			],
			[
				'sku'   => '1471163012122',
				'stock' => 3,
			],
			[
				'sku'   => '1471163012102',
				'stock' => 4,
			],
		];
	}

}