<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html for system status.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Invoice_system_for_woocommerce
 * @subpackage Invoice_system_for_woocommerce/admin/templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$invoice_url      = add_query_arg(
	array(
		'orderid' => $post->ID,
		'action'  => 'generateinvoice',
		'_nonce'  => wp_create_nonce( 'invoice_generate_admin' ),
	),
	$post_page
);
$packing_slip_url = add_query_arg(
	array(
		'orderid' => $post->ID,
		'action'  => 'generateslip',
		'_nonce'  => wp_create_nonce( 'invoice_generate_admin' ),
	),
	$post_page
);
?>
<div id="mwb_isfw_pdf_admin_order_icon"><a href="<?php echo esc_attr( $invoice_url ); ?>" style="margin-left:5px;box-shadow: none;display: inline-block;" id="isfw-print-invoice-order-listing-page" data-order-id="<?php echo esc_html( $post->ID ); ?>"><img src="<?php echo esc_attr( INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/image/invoice_pdf.svg" width="20" height="20" title="<?php esc_html_e( 'Generate invoice', 'invoice-system-for-woocommerce' ); ?>"></a><a href="<?php echo esc_attr( $packing_slip_url ); ?>" style="margin-left:5px;box-shadow: none;display: inline-block;" id="isfw-print-invoice-order-listing-page" data-order-id="<?php echo esc_html( $post->ID ); ?>"><img src="<?php echo esc_attr( INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/image/packing_slip.svg" width="20" height="20" title="<?php esc_html_e( 'Generate packing slip', 'invoice-system-for-woocommerce' ); ?>"></a><?php do_action( 'isfw_custom_column_on_order_listing_hook_admin', $post, $post_page ); ?></div>
