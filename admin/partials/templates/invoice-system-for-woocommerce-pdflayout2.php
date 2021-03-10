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
	$order_details      = do_shortcode( '[isw_fetch_order order_id ="' . $order_id . '"]' );
	$order_details      = json_decode( $order_details, true );
	$order_item_arr     = $order_details['order_items'];
	$order_shipping_arr = $order_details['order_shipping'];
	$order_billing_arr  = $order_details['order_billing'];
	$order_payment_arr  = $order_details['order_payment'];
	$isfw_pdf_settings  = get_option( 'mwb_isfw_pdf_general_settings' );
	if ( $isfw_pdf_settings ) {
		$prefix     = array_key_exists( 'prefix', $isfw_pdf_settings ) ? $isfw_pdf_settings['prefix'] : '';
		$suffix     = array_key_exists( 'suffix', $isfw_pdf_settings ) ? $isfw_pdf_settings['suffix'] : '';
		$digit      = array_key_exists( 'digit', $isfw_pdf_settings ) ? $isfw_pdf_settings['digit'] : 3;
		$logo       = array_key_exists( 'logo', $isfw_pdf_settings ) ? $isfw_pdf_settings['logo'] : '';
		$date       = array_key_exists( 'date', $isfw_pdf_settings ) ? $isfw_pdf_settings['date'] : '';
		$disclaimer = array_key_exists( 'disclaimer', $isfw_pdf_settings ) ? $isfw_pdf_settings['disclaimer'] : 'Thank you for shopping with us.';
		$color      = array_key_exists( 'color', $isfw_pdf_settings ) ? $isfw_pdf_settings['color'] : '#000000';
	} else {
		$prefix     = '';
		$suffix     = '';
		$digit      = 3;
		$logo       = '';
		$date       = '';
		$disclaimer = 'Thank you for shopping with us.';
		$color      = '#000000';
	}
	$prev_invoice_id = get_option( 'isfw_current_invoice_id', true );
	if ( $prev_invoice_id ) {
		$curr_invoice_id = $prev_invoice_id + 1;
		update_option( 'isfw_current_invoice_id', $curr_invoice_id );
	} else {
		$curr_invoice_id = 1;
		update_option( 'isfw_current_invoice_id', 1 );
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
											background-color: gray;
											color: white;
										}
										#isfw-prod-listing-table-bottom {
											border-bottom: 2px solid black;
											margin-top: 20px;
											position: relative;
										}
										
										#isfw-invoice-text{
											color: gray;
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
													' . date( 'd/m/y' ) . '
												</div>
											</div>
											<div id="isfw-invoice-title-right" class="isfw-invoice-inline">
												<h3>
													Company Details
												</h3>
												<div>
													<b>Address</b><br/>
													Lucknow ,<br/> India
													9163758888
													abc@xyz.com
												</div>
											</div>
										</div>';
	if ( $type == 'invoice' ) {
		$html .= '<div id="isfw-invoice-title-to" >
					<b>Invoice to</b><br/>
					<div>
						' . $order_billing_arr["billing_full_name"] . '<br/>
						' . $order_billing_arr["billing_address_1"] . ' ' . $order_billing_arr["billing_address_2"] . '<br/>
						' . $order_billing_arr["billing_phone"] . '<br/>
						' . $order_billing_arr["billing_email"] . '<br/>
					</div>
				</div>';
	} else {
		$html .= '<div id="isfw-invoice-title-to" >
					<b>SHIP TO</b><br/>
					<div>
						' . $order_shipping_arr["shipping_full_name"] . '<br/>
						' . $order_shipping_arr["shipping_address_1"] . ' ' . $order_shipping_arr["shipping_address_2"] . '<br/>
						' . $order_billing_arr["billing_phone"] . '<br/>
						' . $order_billing_arr["billing_email"] . '<br/>
					</div>
				</div>';
	}
	$html .= '<div>
				<table border = "0" cellpadding = "0" cellspacing = "0" id="isfw-prod-listing-table">
					<thead>
						<tr id="isfw-prod-listing-table-title">
							<th id="isfw-table-items">Items</th>
							<th>Quantity</th>
							<th>Price(' . $order_payment_arr["order_currency"] . ')</th>
							<th>Tax (%)</th>
							<th>Amount(' . $order_payment_arr["order_currency"] . ')</th>
						</tr>
					</thead>
					<tbody id="isfw-pdf-prod-body">';
	foreach ( $order_item_arr as $product ) {
		$html .= '<tr>
					<td class="isfw-product-name">' . $product["prod_name"] . '</td>
					<td>' . $product["quantity"] . '</td>
					<td>' . $product["sub_total"] . '</td>
					<td>' . array_shift( array_shift( $product["percent_tax"] ) ) . '</td>
					<td>' . $product["total"] . '</td>
				</tr>';
	}
		$html .= '</tbody>
				</table>
				<div id="isfw-prod-listing-table-bottom"></div>
				<div id="isfw-prod-total-calc">
					<table border = "0" cellpadding = "0" cellspacing = "0">
						<tr>
							<td>subtotal : </td>
							<td>' . $order_payment_arr["order_currency"] . ' ' . $order_payment_arr["sub_total"] . '</td>
						</tr>
						<tr>
							<td>shipping : </td>
							<td>' . $order_payment_arr["order_currency"] . ' ' . $order_shipping_arr["shipping_total"] . '</td>
						</tr>
						<tr>
							<td>tax total : </td>
							<td> ' . $order_payment_arr["order_currency"] . ' ' . array_shift( array_shift( $order_payment_arr["tax_total"] ) ) . '</td>
						</tr>
						<tr>
							<td>Total : </td>
							<td> ' . $order_payment_arr["order_currency"] . ' ' . $order_payment_arr["order_total"] . '</td>
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
