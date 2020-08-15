<?php
/**
 * Products_Updater Class File
 *
 * A class to updater stock amount  of products
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Siawood_Products\Includes\Parts\Products;

use Siawood_Products\Includes\Config\Email_Initial_Values;
use Siawood_Products\Includes\Functions\Log_During_Execution;
use Siawood_Products\Includes\Functions\Log_In_Footer;
use Siawood_Products\Includes\Interfaces\Action_Hook_Interface;
use Siawood_Products\Includes\Parts\Email\Custom_Email;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Products_Updater Class File
 *
 * A class to updater stock amount  of products
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @link       https://wpwebmaster.ir
 */
class Products_Updater implements Action_Hook_Interface {
	use Email_Initial_Values;
	use Log_During_Execution;

	/**
	 * @var array $product_items
	 */
	protected $product_items;
	/**
	 * @var int $success_update_products_count
	 */
	protected $success_update_products_count;
	/**
	 * @var int $fail_update_products_count
	 */
	protected $fail_update_products_count;
	/**
	 * @var int $first_product_counts
	 */
	protected $first_product_counts;
	/**
	 * @var string $hook_for_add_action
	 */
	protected $hook_for_add_action;
	/**
	 * @var array $fail_update_product_items List of product item those are not in database
	 */
	protected $fail_update_product_items;
	/**
	 * @var array $success_update_product_items List of product item which are successfully updated
	 */
	protected $success_update_product_items;


	/**
	 * Products_Updater constructor.
	 *
	 * @param array $product_items
	 * @param int   $first_product_counts
	 */
	public function __construct() {
		$this->success_update_products_count = 0;
		$this->fail_update_products_count    = 0;

		if ( is_admin() ) {
			$this->hook_for_add_action = 'admin_footer';
		} else {
			$this->hook_for_add_action = 'wp_footer';
		}
	}

	/**
	 * Set product items
	 *
	 * @param array $product_items
	 */
	public function set_product_items( $product_items ) {
		$this->product_items = $product_items;
	}

	/**
	 * Set first product counts which is gotten from api
	 *
	 * @param int $first_product_counts
	 */
	public function set_first_product_counts( $first_product_counts ) {
		$this->first_product_counts = (int) $first_product_counts;
	}

	/**
	 * Register actions that the object needs to be subscribed to.
	 *
	 */
	public function register_add_action() {
		add_filter( 'swdprd_params_for_template', [ $this, 'filter_template_params' ] );
		add_action( 'woocommerce_loaded', [ $this, 'update_product_variation_data' ] );
		if ( is_admin() ) {
			add_action( 'admin_footer', [ $this, 'update_last_update_option' ], 999 );
		} else {
			add_action( 'wp_footer', [ $this, 'update_last_update_option' ], 999 );
		}

	}

	public function filter_template_params( $args ) {
		return [
			$this->success_update_products_count,
			$this->fail_update_products_count,
		];
	}

	public function update_product_variation_data() {

		foreach ( $this->product_items as $item ) {
			$id = (int) wc_get_product_id_by_sku( $item['sku'] );
			if ( false == $id || $item['stock'] < 0 ) {
				$this->fail_update_products_count ++;
				$this->fail_update_product_items[] .= $item['sku'];

			} else {
				update_post_meta( $id, '_stock', $item['stock'] );
				if ( '0' === $item['stock'] ) {
					update_post_meta( $id, '_stock_status', 'outofstock' );
				} else {
					update_post_meta( $id, '_stock_status', 'instock' );
				}
				wc_delete_product_transients( $id );
				$this->success_update_products_count ++;
				$this->success_update_product_items[] .= $item['sku'];

			}
		}

		/*$email_template                                      = $this->get_email_templates();
		$email_template['successful_stock_update']['params'] = [
			$this->success_update_products_count,
			$this->fail_update_products_count,
		];*/

		$this->set_tasks_after_update_process(
			new Custom_Email(
				'successful_stock_update',
				$this->get_email_subjects(),
				//$email_template
				$this->get_email_templates()
			),
			new Log_In_Footer()
		);
	}

	/**
	 * Tasks which is needed if Woocommerce is not active.
	 */
	private function set_tasks_after_update_process( Custom_Email $email, Log_In_Footer $log_in_footer_object ) {
		date_default_timezone_set( 'Asia/Tehran' );
		$log_message = 'Update process is succesfully done' . PHP_EOL;
		$log_message .= 'Number of success updated product: ' . $this->success_update_products_count . PHP_EOL;
		$log_message .= 'Number of failed updated product: ' . $this->fail_update_products_count . PHP_EOL;
		$this->write_log_during_execution(
			$log_in_footer_object,
			$log_message,
			SIAWOOD_PRODUCTS_EXECUTION_LOG,
			'Update process results'
		);

		$fail_product_log = '';
		foreach ( $this->fail_update_product_items as $key => $item ) {
			$fail_product_log .= $item . PHP_EOL;
		}
		$this->write_log_during_execution(
			$log_in_footer_object,
			$fail_product_log,
			SIAWOOD_PRODUCTS_LOGS . 'product-items/fail-products-' . date( 'Y-m-d_H-i' ) . '.txt',
			'Fail Products in Update Process'
		);

		$success_product_log = '';
		foreach ( $this->success_update_product_items as $key => $item ) {
			$success_product_log .= $item . PHP_EOL;
		}
		$this->write_log_during_execution(
			$log_in_footer_object,
			$success_product_log,
			SIAWOOD_PRODUCTS_LOGS . 'product-items/success-products-' . date( 'Y-m-d_H-i' ) . '.txt',
			'Success Products in Update Process'
		);

		if ( 'yes' === get_option( 'swdprd_is_need_send_email_after_update' )) {
			$email->register_add_filter_with_arguments( $log_in_footer_object, 'product update process' );
		}




	}

	/**
	 * Update swdprd_last_update in options table
	 */
	public function update_last_update_option() {
		date_default_timezone_set( 'Asia/Tehran' );
		$now_date_time = [
			'date' => date( 'Y-m-d' ),
			'time' => date( 'H:i:s' ),
		];
		update_option( 'swdprd_last_update', $now_date_time );
		update_option( 'swdprd_has_log_for_wrong_url', 'no');
		update_option( 'swdprd_has_log_for_webservice_issue', 'no');
	}


}
