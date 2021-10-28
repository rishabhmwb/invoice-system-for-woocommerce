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
	 * @param boolean $network_wide either network activated or not.
	 * @since 1.0.0
	 * @return void
	 */
	public static function invoice_system_for_woocommerce_activate( $network_wide ) {
		global $wpdb;
		if ( is_multisite() && $network_wide ) {
			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				self::isfw_create_default_settings_on_plugin_activation();
				restore_current_blog();
			}
		} else {
			self::isfw_create_default_settings_on_plugin_activation();
		}
	}

	/**
	 * Update Default value in the option table for settings.
	 *
	 * @since 1.0.1
	 * @return void
	 */
	public static function isfw_create_default_settings_on_plugin_activation() {
		if ( ! get_option( 'isfw_enable_plugin' ) ) {
			$default_options = array(
				'isfw_enable_plugin'                       => 'yes',
				'isfw_send_invoice_automatically'          => 'no',
				'isfw_send_invoice_for'                    => 'wc-completed',
				'isfw_allow_invoice_generation_for_orders' => array( 'wc-completed' ),
				'isfw_generate_invoice_from_cache'         => 'no',
				'isfw_company_name'                        => get_bloginfo( 'company_name' ),
				'isfw_company_address'                     => 'company address',
				'isfw_company_city'                        => 'company city',
				'isfw_company_state'                       => 'company state',
				'isfw_company_pin'                         => '220022',
				'isfw_company_phone'                       => '+917300000000',
				'isfw_company_email'                       => get_bloginfo( 'admin_email' ),
				'isfw_invoice_number_digit'                => 4,
				'isfw_invoice_number_prefix'               => 'mwb',
				'isfw_invoice_number_suffix'               => '',
				'isfw_invoice_disclaimer'                  => 'Thank you for shopping with us.',
				'isfw_invoice_color'                       => '#D1317D',
				'isfw_is_add_logo_invoice'                 => 'no',
				'sub_isfw_upload_invoice_company_logo'     => '',
				'isfw_invoice_template'                    => 'two',
				'isfw_invoice_number_renew_month'          => '',
				'isfw_invoice_number_renew_date'           => '',
			);

			foreach ( $default_options as $option_key => $option_val ) {
				update_option( $option_key, $option_val );
			}
		}
	}
}
