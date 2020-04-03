<?php
/**
 * Initial_Value Class File
 *
 * Role of this class is like RC configuration files in application. If you need
 * to initial value to start your plugin or need them for each time that WordPress
 * run your plugin, you can use from this class.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.0
 */

namespace Siawood_Products\Includes\Config;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Initial_Value.
 * If you need to initial value to start your plugin or need them for
 * each time that WordPress run your plugin, you can use from this class.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 */
class Initial_Value {
	/**
	 * Initial values for complete shortcode class
	 *
	 * @access public
	 * @return array It returns all of arguments that shortcode class needs.
	 */
	public function sample_complete_shortcode() {
		$initial_value = [
			'tag'          => 'msn_new_complete_shortcode',
			'default_atts' => [
				'link' => 'https://wpwebmaster.ir',
				'name' => 'Webmaster WordPress'
			],
		];

		return $initial_value;
	}

	/**
	 * Return custom values to have custom cron schedule for wp_schedule_event
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_get_schedules/
	 * @return array
	 */
	public function sample_custom_cron_schedule() {
		$initial_value = [
			'weekly'      => [
				'interval' => 604800,
				'display'  => __( 'Once Weekly' )
			],
			'twiceweekly' => [
				'interval' => 1209600,
				'display'  => __( 'Twice Weekly' )
			]
		];

		return $initial_value;
	}
}
