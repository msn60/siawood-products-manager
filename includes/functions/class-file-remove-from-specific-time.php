<?php
/**
 * File_Remove_From_Specific_Time Class File
 *
 * This class contains method to remove files in a directory that their modified time is less thant specific time
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.0
 */

namespace Siawood_Products\Includes\Functions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * File_Remove_From_Specific_Time Class File
 *
 * This class contains method to remove files in a directory that their modified time is less thant specific time
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 */
trait File_Remove_From_Specific_Time {

	/**
	 * @param string $path
	 * @param int    $time
	 */
	public function remove_extra_files_from_time( $path , $time = 0  ) {
		$files = glob( $path . "*" );
		$now   = time();
		foreach ( $files as $file ) {
			if ( is_file( $file ) ) {
				if ( $now - filemtime( $file ) >= $time ) {
					unlink( $file );
				}
			}
		}
	}
}
