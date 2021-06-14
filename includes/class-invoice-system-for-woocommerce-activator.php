<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Invoice_system_for_woocommerce
 * @subpackage Invoice_system_for_woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Invoice_system_for_woocommerce
 * @subpackage Invoice_system_for_woocommerce/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Invoice_System_For_Woocommerce_Activator {

	/**
	 * Activator file main method.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function invoice_system_for_woocommerce_activate() {
		( new self() )->isfw_create_default_settings_on_plugin_activation();
	}
	/**
	 * Update Default value in the option table for settings.
	 *
	 * @since 1.0.1
	 * @return void
	 */
	public function isfw_create_default_settings_on_plugin_activation() {
		$previous_settings = get_option( 'mwb_isfw_pdf_general_settings' );
		$order_status      = isset( $previous_settings['order_status'] ) ? $previous_settings['order_status'] : 'wc-completed';
		if ( ! get_option( 'isfw_enable_plugin' ) ) {
			update_option( 'isfw_enable_plugin', 'yes' );
			update_option( 'isfw_send_invoice_automatically', 'no' );
			update_option( 'isfw_send_invoice_for', $order_status );
			update_option( 'isfw_allow_invoice_generation_for_orders', array( $order_status ) );
			update_option( 'isfw_generate_invoice_from_cache', 'no' );
			update_option( 'isfw_company_name', isset( $previous_settings['company_name'] ) ? $previous_settings['company_name'] : get_bloginfo( 'company_name' ) );
			update_option( 'isfw_company_address', isset( $previous_settings['company_address'] ) ? $previous_settings['company_address'] : 'company address' );
			update_option( 'isfw_company_city', isset( $previous_settings['company_city'] ) ? $previous_settings['company_city'] : 'company city' );
			update_option( 'isfw_company_state', isset( $previous_settings['company_state'] ) ? $previous_settings['company_state'] : 'company state' );
			update_option( 'isfw_company_pin', isset( $previous_settings['company_pin'] ) ? $previous_settings['company_pin'] : '220022' );
			update_option( 'isfw_company_phone', isset( $previous_settings['company_phone'] ) ? $previous_settings['company_phone'] : '+917300000000' );
			update_option( 'isfw_company_email', isset( $previous_settings['company_email'] ) ? $previous_settings['company_email'] : get_bloginfo( 'admin_email' ) );
			update_option( 'isfw_invoice_number_digit', isset( $previous_settings['digit'] ) ? $previous_settings['digit'] : 4 );
			update_option( 'isfw_invoice_number_prefix', isset( $previous_settings['prefix'] ) ? $previous_settings['prefix'] : 'mwb' );
			update_option( 'isfw_invoice_number_suffix', isset( $previous_settings['suffix'] ) ? $previous_settings['suffix'] : '' );
			update_option( 'isfw_invoice_disclaimer', isset( $previous_settings['disclaimer'] ) ? $previous_settings['disclaimer'] : 'Thank you for shopping with us.' );
			update_option( 'isfw_invoice_color', isset( $previous_settings['color'] ) ? $previous_settings['color'] : '#D1317D' );
			update_option( 'isfw_is_add_logo_invoice', isset( $previous_settings['is_add_logo'] ) ? $previous_settings['is_add_logo'] : 'no' );
			update_option( 'sub_isfw_upload_invoice_company_logo', isset( $previous_settings['logo'] ) ? $previous_settings['logo'] : '' );
			update_option( 'isfw_invoice_template', isset( $previous_settings['template'] ) ? $previous_settings['template'] : 'two' );
			update_option( 'isfw_invoice_number_renew_month', '' );
			update_option( 'isfw_invoice_number_renew_date', '' );
		}
	}
}
