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
/**
 * Return invoice download button with link.
 *
 * @param string $download_url download url of the invoice.
 * @return string
 */
function return_invoice_download_button( $download_url ) {
	$download_view = get_option( 'isfw_view_pdf' );
	if ( 'view' === $download_view ) {
		$html = '<div id="isfw_guest_download_invoice"><a href="' . $download_url . '" target="_blank"><img src="' . INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/isfw_download_icon.svg" style="max-width: 35px;" title="' . __( 'Download Invoice', 'invoice-system-for-woocommerce' ) . '"><span>' . __( 'Download Invoice', 'invoice-system-for-woocommerce' ) . '</span></a></div>';
	} else {
		$html = '<div id="isfw_guest_download_invoice"><a href="' . $download_url . '"><img src="' . INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/isfw_download_icon.svg" style="max-width: 35px;" title="' . __( 'Download Invoice', 'invoice-system-for-woocommerce' ) . '"><span>' . __( 'Download Invoice', 'invoice-system-for-woocommerce' ) . '</span></a></div>';
	}
	return $html;
}
