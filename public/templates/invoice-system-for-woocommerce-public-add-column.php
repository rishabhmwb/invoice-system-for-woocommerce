<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Invoice_system_for_woocommerce
 * @subpackage Invoice_system_for_woocommerce/public/templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<a href="<?php echo esc_url( $url_here ); ?>/?order_id=<?php echo esc_html( $order->get_id() ); ?>&user_id=<?php echo esc_html( $order->get_customer_id() ); ?>&action=userpdfdownload"><img src="<?php echo esc_url( INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/image/isfw_download_icon.svg" style="max-width: 35px;" title="<?php esc_html_e( 'Download Invoice', 'invoice-system-for-woocommerce' ); ?>"></a>
