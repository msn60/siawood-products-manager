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

		//TODO: check url before start
		//TODO: check status code before continue
		$request = wp_remote_get(
			$url,
			[
				'timeout' => 1200,
			]
		);

		//TODO: check error and if has error return it and log
		/*if( is_wp_error( $request ) ) {
			var_dump($request); // Bail early
			//exit();
		}*/

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
			'count'         => $count,
			'product_items' => $product_items,
		];
	}


}