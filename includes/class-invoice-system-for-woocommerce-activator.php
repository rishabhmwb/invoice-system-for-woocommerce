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
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function invoice_system_for_woocommerce_activate() {
		$company_name   = get_bloginfo( 'company_name' );
		$admin_email    = get_bloginfo( 'admin_email' );
		$company_name   = ( $company_name ) ? $company_name : '';
		$admin_email    = ( $admin_email ) ? $admin_email : '';
		$setting_fields = array(
			'prefix'             => '',
			'suffix'             => '',
			'digit'              => 4,
			'logo'               => '',
			'date'               => '',
			'disclaimer'         => __( 'Thank you for shopping with us.', 'invoice-system-for-woocommerce' ),
			'color'              => '#D1317D',
			'order_status'       => 'wc-completed',
			'company_name'       => $company_name,
			'company_city'       => '',
			'company_state'      => '',
			'company_pin'        => '',
			'company_email'      => $admin_email,
			'company_address'    => '',
			'template'           => 'two',
			'is_add_logo'        => 'no',
			'isfw_enable_plugin' => 'on',
		);
		if ( ! get_option( 'mwb_isfw_pdf_general_settings' ) ) {
			update_option( 'mwb_isfw_pdf_general_settings', $setting_fields );
			update_option( 'isfw_mwb_plugin_enable', 'on' );
		}
	}
}
