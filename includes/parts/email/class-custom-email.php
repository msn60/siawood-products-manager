<?php
/**
 * Custom_Email Class File
 *
 * A class to send customized email
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Siawood_Products\Includes\Parts\Email;

use Siawood_Products\Includes\Functions\Log_In_Footer;
use Siawood_Products\Includes\Functions\Template_Builder;
use Siawood_Products\Includes\Interfaces\Filter_Hook_With_Args_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom_Email Class File
 *
 * A class to send customized email
 *
 * @package    Siawood_Products
 * @author     Mehdi Soltani Neshan <soltani.n.mehdi@gmail.com>
 * @link       https://wpwebmaster.ir
 *
 * @see        https://developer.wordpress.org/reference/functions/wp_mail/
 * @see        https://wordpress.stackexchange.com/questions/96357/include-html-template-file-in-wp-mail
 * @see        https://wordpress.stackexchange.com/questions/224416/how-to-do-action-and-get-a-return-value
 */
class Custom_Email {
	use Template_Builder;

	/**
	 * @var string $to Mail address for sent to it
	 */
	protected $to;
	/**
	 * @var string $subject Array of subjects depends on type
	 */
	protected $subject;
	/**
	 * @var array $template Array of template depends on type
	 */
	protected $template;
	/**
	 * @var array $headers Array of headers to send mail
	 */
	protected $headers;
	/**
	 * @var string $hook_for_add_action
	 */
	protected $hook_for_add_action;

	public function __construct( $type, $subject, $template ) {

		$siawood_admin_email = get_option( 'swdprd_admin_email_address' );
		if ( false == $siawood_admin_email ) {
			$this->to = get_option( 'admin_email' );
		} else {
			$this->to = $siawood_admin_email;
		}
		$this->subject   = $subject[ $type ];
		$this->template  = $template[ $type ];
		$this->headers[] = 'Content-Type: text/html; charset=UTF-8';
		$this->headers[] = 'From: Me Myself <me@example.net>';
		if ( is_admin() ) {
			$this->hook_for_add_action = 'admin_footer';
		} else {
			$this->hook_for_add_action = 'wp_footer';
		}
	}

	public function register_add_filter_with_arguments( Log_In_Footer $log_in_footer_object ) {
		$result = add_filter( $this->hook_for_add_action, [ $this, 'send_email' ] );
		// TODO: check how to get fail with wp_email
		if ( false === $result ) {
			$this->log_sending_email_result( 'fail', $log_in_footer_object );
		} else {
			$this->log_sending_email_result( 'success', $log_in_footer_object );
		}
	}

	public function log_sending_email_result( $type, Log_In_Footer $log_in_footer_object ) {
		$args = [];
		if ( 'fail' === $type ) {
			$args['log_message'] = 'Sending email for disabling Woocommerce plugin was not Successful!!!';
		} else {
			$args['log_message'] = 'Sending email for disabling Woocommerce plugin was  Successful.';
		}
		$args['file_name'] = SIAWOOD_PRODUCTS_LOGS . 'email-logs.txt';
		$args['type']      = 'Sending email for disabling Woocommerce';
		$log_in_footer_object->register_add_action_with_arguments( $args );

	}

	public function send_email() {
		ob_start();
		$this->load_template( $this->template['template'], $this->template['params'], $this->template['type'] );
		$email_content = ob_get_contents();
		ob_end_clean();
		$result = \wp_mail( $this->to, $this->subject, $email_content, $this->headers );;

		return $result;

		// TODO: Change sender name and email
		//https://www.wpbeginner.com/plugins/how-to-change-sender-name-in-outgoing-wordpress-email/
		//https://wordpress.org/support/topic/change-sender-email-from-wordpress/

	}


}
