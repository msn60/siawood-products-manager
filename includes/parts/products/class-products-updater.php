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
		add_action( 'plugins_loaded', [ $this, 'update_stocks_amount' ] );
	}

	public function update_stocks_amount() {

		foreach ( $this->product_items as $item ) {
			$id = (int) \wc_get_product_id_by_sku( $item['sku'] );
			if ( false == $id ) {
				$this->fail_update_products_count ++;
				$this->fail_update_product_items['not_in_database'] = $item['sku'];

			} else {
				update_post_meta( $id, '_stock', $item['stock'] );
				if ( '0' === $item['stock'] ) {
					update_post_meta( $id, '_stock_status', 'outofstock' );
				} else {
					update_post_meta( $id, '_stock_status', 'instock' );
				}
				$this->success_update_products_count ++;
				$this->success_update_product_items[] = $item['sku'];

			}
		}

		$email_template                                      = $this->get_email_templates();
		$email_template['successful_stock_update']['params'] = [
			$this->success_update_products_count,
			$this->fail_update_products_count,
		];
		$this->set_tasks_after_update_process(
			new Custom_Email(
				'successful_stock_update',
				$this->get_email_subjects(),
				$email_template
			),
			new Log_In_Footer()
		);
	}

	/**
	 * Tasks which is needed if Woocommerce is not active.
	 */
	private function set_tasks_after_update_process( Custom_Email $email, Log_In_Footer $log_in_footer_object ) {

		$execution_args                = [];
		$execution_args['log_message'] = 'Update process is succesfully done' . PHP_EOL;
		$execution_args['log_message'] .= 'Number of success updated product: ' . $this->success_update_products_count . PHP_EOL;
		$execution_args['log_message'] .= 'Number of failed updated product: ' . $this->fail_update_products_count . PHP_EOL;
		$execution_args['file_name']   = SIAWOOD_PRODUCTS_LOGS . 'execution-logs.txt';
		$execution_args['type']        = 'Update process results';
		$log_in_footer_object->register_add_action_with_arguments( $execution_args );

		$email->register_add_filter_with_arguments( $log_in_footer_object );


	}


}
