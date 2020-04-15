<?php
/**
 * Display log of Siawood Plugin in the WC settings page
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

$GLOBALS['hide_save_button'] = true;
$msn_temp_report             = '';
$file                        = file( SIAWOOD_PRODUCTS_PATH . 'logs/execution-logs.txt' );

for ( $i = max( 0, count( $file ) - 15 ); $i < count( $file ); $i ++ ) {
	$msn_temp_report .= $file[ $i ] . '<br>';
}

?>
    <h2>گزارش های کارکرد پلاگین</h2>

    <div class="msn-report-section">
		<?php echo $msn_temp_report; ?>
    </div>

<?php
