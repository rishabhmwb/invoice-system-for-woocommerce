<?php
/**
 * This is template one for the pdf generation.
 *
 * @package invoice-system-forwoocommerce.
 *
 * @return void
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Return the html data for the second template.
 *
 * @param int    $order_id order id.
 * @param string $type packing slip or the invoice.
 * @return string
 */
function return_ob_value( $order_id, $type ) {
	$order_details         = do_shortcode( '[isw_fetch_order order_id ="' . $order_id . '"]' );
	$order_details         = json_decode( $order_details, true );
	$shipping_details      = $order_details['shipping_details'];
	$billing_details       = $order_details['billing_details'];
	$order_product_details = $order_details['product_details'];
	$isfw_pdf_settings     = get_option( 'mwb_isfw_pdf_general_settings' );
	if ( $isfw_pdf_settings ) {
		$prefix          = array_key_exists( 'prefix', $isfw_pdf_settings ) ? $isfw_pdf_settings['prefix'] : '';
		$suffix          = array_key_exists( 'suffix', $isfw_pdf_settings ) ? $isfw_pdf_settings['suffix'] : '';
		$digit           = array_key_exists( 'digit', $isfw_pdf_settings ) ? $isfw_pdf_settings['digit'] : 3;
		$logo            = array_key_exists( 'logo', $isfw_pdf_settings ) ? $isfw_pdf_settings['logo'] : '';
		$date            = array_key_exists( 'date', $isfw_pdf_settings ) ? $isfw_pdf_settings['date'] : '';
		$disclaimer      = array_key_exists( 'disclaimer', $isfw_pdf_settings ) ? $isfw_pdf_settings['disclaimer'] : 'Thank you for shopping with us.';
		$color           = array_key_exists( 'color', $isfw_pdf_settings ) ? $isfw_pdf_settings['color'] : '#000000';
		$company_name    = array_key_exists( 'company_name', $isfw_pdf_settings ) ? $isfw_pdf_settings['company_name'] : '';
		$company_city    = array_key_exists( 'company_city', $isfw_pdf_settings ) ? $isfw_pdf_settings['company_city'] : '';
		$company_state   = array_key_exists( 'company_state', $isfw_pdf_settings ) ? $isfw_pdf_settings['company_state'] : '';
		$company_pin     = array_key_exists( 'company_pin', $isfw_pdf_settings ) ? $isfw_pdf_settings['company_pin'] : '';
		$company_phone   = array_key_exists( 'company_phone', $isfw_pdf_settings ) ? $isfw_pdf_settings['company_phone'] : '';
		$company_email   = array_key_exists( 'company_email', $isfw_pdf_settings ) ? $isfw_pdf_settings['company_email'] : '';
		$company_address = array_key_exists( 'company_address', $isfw_pdf_settings ) ? $isfw_pdf_settings['company_address'] : '';
	} else {
		$prefix          = '';
		$suffix          = '';
		$digit           = 3;
		$logo            = '';
		$date            = '';
		$disclaimer      = 'Thank you for shopping with us.';
		$color           = '#000000';
		$company_name    = '';
		$company_city    = '';
		$company_state   = '';
		$company_pin     = '';
		$company_phone   = '';
		$company_email   = '';
		$company_address = '';
	}
	$in_id = get_post_meta( $order_id, 'isfw_order_invoice_id', true );
	if ( $in_id ) {
		$curr_invoice_id = $in_id;
	} else {
		$prev_invoice_id = get_option( 'isfw_current_invoice_id', true );
		if ( $prev_invoice_id ) {
			$curr_invoice_id = $prev_invoice_id + 1;
			update_option( 'isfw_current_invoice_id', $curr_invoice_id );
		} else {
			$curr_invoice_id = 1;
			update_option( 'isfw_current_invoice_id', 1 );
		}
		update_post_meta( $order_id, 'isfw_order_invoice_id', $curr_invoice_id );
	}
	$invoice_number = str_pad( $curr_invoice_id, $digit, '0', STR_PAD_LEFT );
	$invoice_id     = $prefix . $invoice_number . $suffix;
	$html           = '<!DOCTYPE html>
								<html>
								<head>
									<title> INVOICE SYSTEM FOR WOOCOMMERCE </title>
									<style>
										#isfw-pdf-header {
											margin-bottom: -80px;
										}
										#isfw-invoice-title-right {
											margin-top: -20px;
										}
								
										.isfw-invoice-inline {
											display: inline-block;
											width: 50%;
										}
										table#isfw-prod-listing-table{
											margin-top: 40px;
											width: 100%;
										}
										table#isfw-prod-listing-table tr th {
											text-align: center;
											padding: 5px;
										}
										table#isfw-prod-listing-table tr #isfw-table-items {
											text-align: left;
										}
								
										#isfw-pdf-prod-body tr td {
											text-align: center;
											padding: 15px 0;
										}
										#isfw-pdf-prod-body tr .isfw-product-name {
											text-align: left;
										}
										#isfw-prod-listing-table-title {
											background-color: ' . $color . ';
											color: white;
										}
										#isfw-prod-listing-table-bottom {
											border-bottom: 2px solid black;
											margin-top: 20px;
											position: relative;
										}
										
										#isfw-invoice-text{
											color: ' . $color . ';
											margin-bottom: 30px;
										}
								
										#isfw-prod-total-calc table {
											text-align: right;
											table-layout: fixed;
											width: 96%;
											margin-top: 30px;
										}
										.isfw-invoice-greetings {
											margin-top: 40px;
										}
										#isfw-invoice-title-right {
											margin-top: -20px;
											text-align: right;
										}
									</style>
								</head>
								<body>
									<div id="isfw-pdf">
										<h2 id="isfw-invoice-text">
										INVOICE
										</h2>
										<div id="isfw-pdf-header">
											<div id="isfw-invoice-title-left" class="isfw-invoice-inline">
												<div>
													<b>Invoice Number</b><br/>
													' . $invoice_id . '
												</div>
												<div>
													<b>Date</b><br/>
													' . $billing_details["order_created_date"] . '
												</div>
											</div>
											<div id="isfw-invoice-title-right" class="isfw-invoice-inline">
												<div>
													<b>' . ucfirst( $company_name ) . '</b><br/>
													' . ucfirst( $company_address ) . ' ,' . ucfirst( $company_city ) . '<br/>
													' . ucfirst( $company_state ) . ' ,<br/> ' . $company_pin . '<br/>
													' . $company_phone . '<br/>
													' . $company_email . '
												</div>
											</div>
										</div>';
	if ( $type == 'invoice' ) {
		$html .= '<div id="isfw-invoice-title-to" >
					<b>Invoice to</b><br/>
					<div>
						' . ucfirst( $billing_details["billing_first_name"] ) . ' ' .ucfirst( $billing_details["billing_last_name"] ) . '<br/>
						' . ucfirst( $billing_details["billing_address_1"] ) . ' ' . ucfirst( $billing_details["billing_address_2"] ) . '<br/>
						' . ucfirst( $billing_details["billing_city"] ) . '<br/>
						' . ucfirst( $billing_details["billing_state"] ) . '<br/>
						' . $billing_details["billing_postcode"] . '<br/>
						' . $billing_details["billing_phone"] . '<br/>
						' . $billing_details["billing_email"] . '<br/>
					</div>
				</div>';
	} else {
		$html .= '<div id="isfw-invoice-title-to" >
					<b>SHIP TO</b><br/>
					<div>
						' . ucfirst( $shipping_details["shipping_first_name"] ) . ' ' . ucfirst( $shipping_details["shipping_last_name"] ) . '<br/>
						' . ucfirst( $shipping_details["shipping_address_1"] ) . ' ' . ucfirst( $shipping_details["shipping_address_2"] ) . '<br/>
						' . ucfirst( $shipping_details["shipping_city"] ) . '<br/>
						' . ucfirst( $shipping_details["shipping_state"] ) . '<br/>
						' . $shipping_details["shipping_postcode"] . '<br/>
						' . $billing_details["billing_phone"] . '<br/>
						' . $billing_details["billing_email"] . '<br/>
					</div>
				</div>';
	}
	$html .= '<div>
				<table border = "0" cellpadding = "0" cellspacing = "0" id="isfw-prod-listing-table">
					<thead>
						<tr id="isfw-prod-listing-table-title">
							<th id="isfw-table-items">Items</th>
							<th>Quantity</th>
							<th>Price(' . $billing_details["order_currency"] . ')</th>
							<th>Tax (%)</th>
							<th>Amount(' . $billing_details["order_currency"] . ')</th>
						</tr>
					</thead>
					<tbody id="isfw-pdf-prod-body">';
	foreach ( $order_product_details as $product ) {
		$html .= '<tr>
					<td class="isfw-product-name">' . $product["product_name"] . '</td>
					<td>' . $product["product_quantity"] . '</td>
					<td>' . $product["product_price"] . '</td>
					<td>' . $product["tax_percent"] . '</td>
					<td>' . $product["product_total"] . '</td>
				</tr>';
	}
		$html .= '</tbody>
				</table>
				<div id="isfw-prod-listing-table-bottom"></div>
				<div id="isfw-prod-total-calc">
					<table border = "0" cellpadding = "0" cellspacing = "0">
						<tr>
							<td>Subtotal(' . $billing_details["order_currency"] . '): ' . $billing_details["order_subtotal"] . '</td>
						</tr>
						<tr>
							<td>Shipping(' . $billing_details["order_currency"] . '): ' . $shipping_details["shipping_total"] . '</td>
						</tr>
						<tr>
							<td>Total tax(' . $billing_details["order_currency"] . '): ' . $billing_details["tax_totals"] . '</td>
						</tr>
						<tr>
							<td>Total(' . $billing_details["order_currency"] . '): ' . $billing_details["cart_total"] . '</td>
						</tr>
					</table>
				</div>
				<div class="isfw-invoice-greetings">
					<b>' . $disclaimer . '</b>
				</div>
			</div>
		</div>
	</body>
	</html>';
	return $html;
}
