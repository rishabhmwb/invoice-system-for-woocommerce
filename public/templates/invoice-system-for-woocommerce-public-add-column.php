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
$to_url = add_query_arg(
	array(
		'order_id' => $order->get_id(),
		'action'   => 'userpdfdownload',
		'_nonce'   => wp_create_nonce( 'user_pdf_nonce' ),
	),
	$url_here
);

?>
<a href="<?php echo esc_url( $to_url ); ?>" ><img src="<?php echo esc_url( INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/image/isfw_download_icon.svg" style="max-width: 35px;" title="<?php esc_html_e( 'Download Invoice', 'invoice-system-for-woocommerce' ); ?>"></a>
