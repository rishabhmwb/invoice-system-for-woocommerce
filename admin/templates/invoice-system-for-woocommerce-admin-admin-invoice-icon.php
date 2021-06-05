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
?>
<div id="mwb_isfw_pdf_admin_order_icon"><a href="<?php echo esc_attr( $post_page ); ?>?orderid=<?php echo esc_html( $post->ID ); ?>&action=generateinvoice" style="margin-left:5px;box-shadow: none;display: inline-block;" id="isfw-print-invoice-order-listing-page" data-order-id="<?php echo esc_html( $post->ID ); ?>"><img src="<?php echo esc_attr( INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/src/images/invoice_pdf.svg" width="20" height="20" title="<?php esc_html_e( 'Generate invoice', 'invoice-system-for-woocommerce' ); ?>"></a><a href="<?php echo esc_attr( $post_page ); ?>?orderid=<?php echo esc_html( $post->ID ); ?>&action=generateslip" style="margin-left:5px;box-shadow: none;display: inline-block;" id="isfw-print-invoice-order-listing-page" data-order-id="<?php echo esc_html( $post->ID ); ?>"><img src="<?php echo esc_attr( INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/src/images/packing_slip.svg" width="20" height="20" title="<?php esc_html_e( 'Generate packing slip', 'invoice-system-for-woocommerce' ); ?>"></a></div>
