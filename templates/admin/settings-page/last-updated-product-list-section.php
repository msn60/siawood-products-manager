<?php

/**
 * Display list of product items that had been updated or failed  in the WC settings page
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.2.1
 */


$products_items_directory_path = SIAWOOD_PRODUCTS_PATH . 'logs/product-items/';
$all_files_in_product_items_directory = array_reverse(scandir($products_items_directory_path));
$products_items_directory_url = plugins_url( '/siawood-products/logs/product-items/' );

$GLOBALS['hide_save_button'] = true;


?>
	<h2>محصولات با آپدیت موفقیت آمیز</h2>

	<div class="msn-report-section">
		<?php
		$counter = 0;
		foreach ( $all_files_in_product_items_directory as $item ) {
			if ($counter > 9) {
				break;
			}
			$pattern = '/^success/';
			$matched = preg_match($pattern, $item, $matches);
			if ($matched) {
				$main_url = $products_items_directory_url . $item;
				echo "<a href='$main_url' target='_blank'>$item</a>";
				echo '<br>';
				$counter++;
			}
		}
    ?>
	</div>

  <h2>محصولات با آپدیت ناموفق</h2>

  <div class="msn-report-section">
		<?php
    $counter = 0;
		foreach ( $all_files_in_product_items_directory as $item ) {
		  if ($counter > 9) {
		    break;
      }
			$pattern = '/^fail/';
			$matched = preg_match($pattern, $item, $matches);
			if ($matched) {
				$main_url = $products_items_directory_url . $item;
				echo "<a href='$main_url' target='_blank'>$item</a>";
				echo '<br>';
				$counter++;
			}
		}
    ?>
  </div>

<?php