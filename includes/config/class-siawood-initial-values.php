<?php
/**
 * Siawood_Initial_Values Class File
 *
 * Role of this class is like RC configuration files in application. If you need
 * to initial value to start your plugin or need them for each time that WordPress
 * run your plugin, you can use from this class.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Siawood_Products\Includes\Config;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Siawood_Initial_Values.
 * If you need to initial value to start your plugin or need them for
 * each time that WordPress run your plugin, you can use from this class.
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 */
trait Siawood_Initial_Values {

	public function get_siawood_settings_page_elements( $prefix ) {
		$propulsionTypes = [
			'unknown'     => __( '', 'p3k-galactica' ),
			'light_speed' => __( 'Light Speed', 'p3k-galactica' ),
			'ftl_speed'   => __( 'Faster Than Light', 'p3k-galactica' ),
		];

		$settings = [
			[

				'name' => __( 'General Configuration', 'p3k-galactica' ),
				'type' => 'title',
				'id'   => $prefix . 'general_config_settings'
			],
			[
				'id'       => $prefix . 'battlestar_group',
				'name'     => __( 'Battlestar Group', 'p3k-galactica' ),
				'type'     => 'number',
				'desc_tip' => __( ' The numeric designation of this Battlestar Group.', 'p3k-galactica' )
			],
			[
				'id'       => $prefix . 'flagship',
				'name'     => __( 'Flagship', 'p3k-galactica' ),
				'type'     => 'text',
				'desc_tip' => __( ' The name of this Battlestar Group flagship. ', 'p3k-galactica' )
			],
			[
				'id'   => '',
				'name' => __( 'General Configuration', 'p3k-galactica' ),
				'type' => 'sectionend',
				'desc' => '',
				'id'   => $prefix . 'general_config_settings'
			],
			[
				'name' => __( 'Flagship Settings', 'p3k-galacticay' ),
				'type' => 'title',
				'id'   => $prefix . 'flagship_settings',
			],
			[
				'id'       => $prefix . 'ship_propulsion_type',
				'name'     => __( 'Propulsion Type', 'p3k-galactica' ),
				'type'     => 'select',
				'class'    => 'wc-enhanced-select',
				'options'  => $propulsionTypes,
				'desc_tip' => __( ' The primary propulsion type utilized by this flagship.', 'p3k-galactica' )
			],
			[
				'id'       => $prefix . 'ship_length',
				'name'     => __( 'Length', 'p3k-galactica' ),
				'type'     => 'number',
				'desc_tip' => __( ' The length in meters of this ship.', 'p3k-galactica' )
			],
			[
				'id'      => $prefix . 'ship_in_service',
				'name'    => __( 'In Service?', 'p3k-galactica' ),
				'type'    => 'checkbox',
				'desc'    => __( 'Uncheck this box if the ship is out of service.', 'p3k-galactica' ),
				'default' => 'yes'
			],
			[
				'id'   => '',
				'name' => __( 'Flagship Settings', 'p3k-galactica' ),
				'type' => 'sectionend',
				'desc' => '',
				'id'   => $prefix . 'flagship_settings',
			],
		];

		return $settings;
	}

	public function get_siawood_general_settings_page_elements( $prefix ) {

		$settings = [
			[

				'name' => __( 'تنظیمات وب سرویس', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'type' => 'title',
				'id'   => $prefix . 'general_webservice_settings'
			],
			[
				'id'       => $prefix . 'webservice_ip_address',
				'name'     => __( 'آدرس آی پی وب سرویس', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'type'     => 'text',
				'desc_tip' => __( 'آدرس کامل وب سرویس به همراه پورت به صورت کامل، باید در این قسمت وارد شود', SIAWOOD_PRODUCTS_TEXTDOMAIN )
			],
			[
				'id'   => '',
				'name' => __( 'تنظیمات وب سرویس', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'type' => 'sectionend',
				'desc' => '',
				'id'   => $prefix . 'general_webservice_settings'
			],
			[

				'name' => __( 'تنظیمات ایمیل', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'type' => 'title',
				'id'   => $prefix . 'general_email_settings'
			],
			[
				'id'       => $prefix . 'admin_email_address',
				'name'     => __( 'ایمیل مدیریت سایت', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'type'     => 'email',
				'desc_tip' => __( 'آدرس ایمیلی که اطلاعات مرتبط با پلاگین به آن ارسال می شود، در این قسمت وارد می شود', SIAWOOD_PRODUCTS_TEXTDOMAIN )
			],
			[
				'id'       => $prefix . 'is_need_send_email_after_update',
				'name'     => __( 'ارسال ایمیل بعد از آپدیت', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'type'     => 'checkbox',
				'desc'     => __( 'ارسال ایمیل بعد از انجام آپدیت موجودی محصولات', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'desc_tip' => __( 'در صورتی که می خواهید بعد از هر بار آپدیت موجودی، با ایمیل به شما اطلاع رسانی شود، این گزینه را فعال کنید',
					SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'default'  => 'yes'
			],
			[
				'id'       => $prefix . 'is_need_send_email_for_warning',
				'name'     => __( 'ارسال ایمیل های هشدار', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'type'     => 'checkbox',
				'desc'     => __( 'ارسال ایمیل در صورت وجود داشتن هشدار', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'desc_tip' => __( 'در صورتی که می خواهید با فعال نبودن ووکامرس یا در دسترس نبودن سرویس، با ایمیل به شما اطلاع رسانی شود، این گزینه را فعال کنید',
					SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'default'  => 'yes'
			],
			[
				'id'       => $prefix . 'only_update_manual',
				'name'     => __( 'فرآیند آپدیت محصولات', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'type'     => 'checkbox',
				'desc'     => __( 'آپدیت محصولات فقط به صورت دستی', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'desc_tip' => __( 'در صورتی که می خواهید فقط محصولات به صورت دستی آپدیت شوند، این گزینه را فعال کنید',
					SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'default'  => 'no'
			],
			[
				'id'       => $prefix . 'is_need_log_for_success_failed_products',
				'name'     => __( 'لاگ لیست محصولات', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'type'     => 'checkbox',
				'desc'     => __( 'ثبت لیست کلیه محصولات آپدیت شده و آپدیت نشده', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'desc_tip' => __( 'در صورتی که می خواهید لیست همه محصولاتی که آپدیت شده یا نشده اند را لاگ کنید، این گزینه را فعال نمایید',
					SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'default'  => 'no'
			],
			[
				'id'   => '',
				'name' => __( 'تنظیمات ایمیل', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'type' => 'sectionend',
				'desc' => '',
				'id'   => $prefix . 'general_email_settings'
			],

		];

		return $settings;
	}

	public function get_siawood_manual_update_settings_page_elements( $prefix ) {

		$settings = [
			[

				'name' => __( 'اجرای دستی بروز رسانی محصولات', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'type' => 'title',
				'id'   => $prefix . 'manual_update_webservice_settings'
			],
			[
				'id'       => $prefix . 'is_need_update_stock_manually',
				'name'     => __( 'به روز رسانی انبار', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'type'     => 'checkbox',
				'desc'     => __( 'به روز رسانی محصولات به صورت دستی', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'desc_tip' => __( 'در صورتی که می خواهید برنامه آپدیت انبار به صورتی فوری اجرا شود، از این گزینه استفاده کنید',
					SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'default'  => 'yes'
			],
			[
				'id'   => '',
				'name' => __( 'تنظیمات وب سرویس', SIAWOOD_PRODUCTS_TEXTDOMAIN ),
				'type' => 'sectionend',
				'desc' => '',
				'id'   => $prefix . 'manual_update_webservice_settings'
			],


		];

		return $settings;
	}
}
