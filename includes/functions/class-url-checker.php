<?php
/**
 * Url_Checker trait File
 *
 * This class contains functions to check and validate url
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
 * Url_Checker trait File
 *
 * This class contains functions to check and validate url
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 *
 * @see        https://stackoverflow.com/questions/27745/getting-parts-of-a-url-regex
 */
trait Url_Checker {

	/**
	 * Check sending string which is correct url or not
	 *
	 * @access  public
	 *
	 * @param string $url
	 *
	 * @return bool True if match with url pattern
	 */
	public function is_valid_url( $url ) {
		return preg_match( '/^((http[s]?):\/\/)(.*):(\d*)\/?(.*)/', $url );
	}

	/**
	 * Return all of matches parts of url
	 *
	 * @access  public
	 *
	 * @param $url
	 *
	 * @return mixed
	 */
	public function get_matches_in_url( $url ) {
		preg_match_all( '/^((http[s]?):\/\/)(.*):(\d*)\/?(.*)/', $url, $matches );

		return $matches;
	}

}
