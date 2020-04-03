<?php
/**
 * Constant Class File
 *
 * This file contains Constant class which defines needed constants to ease
 * your plugin development processes.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.0
 */

namespace Siawood_Products\Includes\Init;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class Constant
 *
 * This class defines needed constants that you will use in plugin development.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 */
class Constant {

	/**
	 * Define define_constant method in Constant class
	 *
	 * It defines all of constants that you need
	 *
	 * @access  public
	 * @static
	 */
	public static function define_constant() {

		/**
		 * SIAWOOD_PRODUCTS_PATH constant.
		 * It is used to specify plugin path
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_PATH' ) ) {
			define( 'SIAWOOD_PRODUCTS_PATH', trailingslashit( plugin_dir_path( dirname( dirname( __FILE__ ) ) ) ) );
		}

		/**
		 * SIAWOOD_PRODUCTS_URL constant.
		 * It is used to specify plugin urls
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_URL' ) ) {
			define( 'SIAWOOD_PRODUCTS_URL', trailingslashit( plugin_dir_url( dirname( dirname( __FILE__ ) ) ) ) );
		}

		/**
		 * SIAWOOD_PRODUCTS_IMG constant.
		 * It is used to specify image urls inside assets directory. It's used in front end and
		 * using to load related image files for front end user.
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_IMG' ) ) {
			define( 'SIAWOOD_PRODUCTS_IMG', trailingslashit( SIAWOOD_PRODUCTS_URL ) . 'assets/images/' );
		}

		/**
		 * SIAWOOD_PRODUCTS_ADMIN_CSS constant.
		 * It is used to specify css urls inside assets/admin directory. It's used in WordPress
		 *  admin panel and using to  load related CSS files for admin user.
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_ADMIN_CSS' ) ) {
			define( 'SIAWOOD_PRODUCTS_ADMIN_CSS', trailingslashit( SIAWOOD_PRODUCTS_URL ) . 'assets/admin/css/' );
		}

		/**
		 * SIAWOOD_PRODUCTS_ADMIN_JS constant.
		 * It is used to specify JS urls inside assets/admin directory. It's used in WordPress
		 *  admin panel and using to  load related JS files for admin user.
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_ADMIN_JS' ) ) {
			define( 'SIAWOOD_PRODUCTS_ADMIN_JS', trailingslashit( SIAWOOD_PRODUCTS_URL ) . 'assets/admin/js/' );
		}

		/**
		 * SIAWOOD_PRODUCTS_ADMIN_IMG constant.
		 * It is used to specify image urls inside assets/admin directory. It's used in WordPress
		 *  admin panel and using to  load related JS files for admin user.
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_ADMIN_IMG' ) ) {
			define( 'SIAWOOD_PRODUCTS_ADMIN_IMG', trailingslashit( SIAWOOD_PRODUCTS_URL ) . 'assets/admin/images/' );
		}

		/**
		 * SIAWOOD_PRODUCTS_TPL constant.
		 * It is used to specify template urls inside templates directory.
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_TPL' ) ) {
			define( 'SIAWOOD_PRODUCTS_TPL', trailingslashit( SIAWOOD_PRODUCTS_PATH . 'templates' ) );
		}

		/**
		 * SIAWOOD_PRODUCTS_INC constant.
		 * It is used to specify include path inside includes directory.
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_INC' ) ) {
			define( 'SIAWOOD_PRODUCTS_INC', trailingslashit( SIAWOOD_PRODUCTS_PATH . 'includes' ) );
		}

		/**
		 * SIAWOOD_PRODUCTS_LANG constant.
		 * It is used to specify language path inside languages directory.
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_LANG' ) ) {
			define( 'SIAWOOD_PRODUCTS_LANG', trailingslashit( SIAWOOD_PRODUCTS_PATH . 'languages' ) );
		}

		/**
		 * SIAWOOD_PRODUCTS_TPL_ADMIN constant.
		 * It is used to specify template urls inside templates/admin directory. If you want to
		 * create a template for admin panel or administration purpose, you will use from it.
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_TPL_ADMIN' ) ) {
			define( 'SIAWOOD_PRODUCTS_TPL_ADMIN', trailingslashit( SIAWOOD_PRODUCTS_TPL . 'admin' ) );
		}

		/**
		 * SIAWOOD_PRODUCTS_TPL constant.
		 * It is used to specify template urls inside templates directory.
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_LOGS' ) ) {
			define( 'SIAWOOD_PRODUCTS_LOGS', trailingslashit( SIAWOOD_PRODUCTS_PATH . 'logs' ) );
		}

		/**
		 * SIAWOOD_PRODUCTS_CSS_VERSION constant.
		 * You can use from this constant to apply on main CSS file when you have changed it.
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_ADMIN_CSS_VERSION' ) ) {
			define( 'SIAWOOD_PRODUCTS_ADMIN_CSS_VERSION', 1 );
		}
		/**
		 * SIAWOOD_PRODUCTS_JS_VERSION constant.
		 * You can use from this constant to apply on main JS file when you have changed it.
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_ADMIN_JS_VERSION' ) ) {
			define( 'SIAWOOD_PRODUCTS_ADMIN_JS_VERSION', 1 );
		}

		/**
		 * SIAWOOD_PRODUCTS_VERSION constant.
		 * It defines version of plugin for management tasks in your plugin
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_VERSION') ) {
			define( 'SIAWOOD_PRODUCTS_VERSION', '1.0.1' );
		}

		/**
		 * SIAWOOD_PRODUCTS_PLUGIN constant.
		 * It defines name of plugin for management tasks in your plugin
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_PLUGIN') ) {
			define( 'SIAWOOD_PRODUCTS_PLUGIN', 'siawood-products' );
		}

		/**
		 * SIAWOOD_PRODUCTS_DB_VERSION constant
		 *
		 * It defines database version
		 * You can use from this constant to apply your changes in updates or
		 * activate plugin again
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_DB_VERSION') ) {
			define( 'SIAWOOD_PRODUCTS_DB_VERSION', 1 );
		}

		/**
		 * SIAWOOD_PRODUCTS_TEXTDOMAIN constant
		 *
		 * It defines text domain name for plugin
		 */
		if ( ! defined( 'SIAWOOD_PRODUCTS_TEXTDOMAIN') ) {
			define( 'SIAWOOD_PRODUCTS_TEXTDOMAIN', 'siawood-products-textdomain' );
		}
		/*In future maybe I want to add constants for separated upload directory inside plugin directory*/
	}
}
