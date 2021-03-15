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
		$blog_info      = get_bloginfo();
		$blog_info      = is_array( $blog_info ) ? $blog_info : array();
		$company_name   = array_key_exists( 'company_name', $blog_info ) ? $blog_info['company_name'] : '';
		$admin_email    = array_key_exists( 'admin_email', $blog_info ) ? $blog_info['admin_email'] : '';
		$setting_fields = array(
			'prefix'             => '',
			'suffix'             => '',
			'digit'              => 4,
			'logo'               => '',
			'date'               => '',
			'disclaimer'         => __( 'Thank you for shopping with us.', 'invoice-system-for-woocommerce' ),
			'color'              => 'Thank you for shopping with us.',
			'order_status'       => 'wc-never',
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
		update_option( 'mwb_isfw_pdf_general_settings', $setting_fields );
	}

}
