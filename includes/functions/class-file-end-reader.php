<?php
/**
 * File_End_Reader Class File
 *
 * This class contains functions to read  n line from end of a file and return it as a string
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
 * File_End_Reader Class File
 *
 * This class contains functions to read  n line from end of a file and return it as a string
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 */
trait File_End_Reader {

	/**
	 * @param string $filename
	 * @param int $line_number
	 *
	 * @return string
	 */
	public function get_file_end( $filename, $line_number ) {
		$file = file($filename);
		$result = '';
		for ($i = max(0, count($file)- $line_number); $i < count($file); $i++) {
		  $result .= $file[$i] ;
		}
		return $result;
	}
}
