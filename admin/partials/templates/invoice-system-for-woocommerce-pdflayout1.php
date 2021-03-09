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
 * Function to return the html for the first template.
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
								<html lang="en">
									<head>
										<style>
												#company-details-mwbpdf-builder{
														cursor: pointer;
												}
												.pdf-color-template{
														color: ' . $color . ';
												}
												#invoice-mwbpdf-builder{
														margin-left: 500px;
														position: relative;
														top: -120px;
												}
												#detail-to{
														position: relative;
														top: -120px;
												}
												.background-pdf-color-template{
														color: white;
														background-color:' . $color . ';
												}
												#my-table-mwb-prod-listing{
														border-collapse: collapse;
														position:relative;
														top:-100px;
												}
												#my-table-mwb-prod-listing thead tr th, #my-table-mwb-prod-listing tbody tr td{
														padding: 0px 50px;
														border: 2px solid black;
												}
												.no-border{
													border: none!important;
												}
										</style>
									</head>
								<body>
									<div id="mwb-pdf-form">
										<form action="" method="post">
										<div id="header-first">
											<div id="company-details-mwbpdf-builder">
											<div><h2 class="pdf-color-template">[Company Name]</h2></div>
											<table>
												<tbody>
												<tr>
													<td>[Street Address]</td>
												</tr>
												<tr>
													<td>[City, ST ZIP]</td>
												</tr>
												<tr>
													<td>Phone : [000] 000-000</td>
												</tr>
												</tbody>
											</table>
											</div>
											<div id="invoice-mwbpdf-builder">
											<div><h2 class="pdf-color-template">Invoice</h2></div>
											<table class="invoice-title-mwbpdf">
												<thead class="background-pdf-color-template" style="text-align:right;">
												<tr>
													<th>
													Invoice
													</th>
													<th>
													Date
													</th>
												</tr>
												</thead>
												<tbody>
												<tr>
													<td>
													' . $invoice_id . '
													</td>
													<td>
													01:02:2020
													</td>
												</tr>
												</tbody>
											</table>
											<table class="invoice-title-mwbpdf">
												<thead class="background-pdf-color-template">
												<tr>
													<th>
													Customer ID
													</th>
													<th>
													Terms
													</th>
												</tr>
												</thead>
												<tbody>
												<tr>
													<td>
													564
													</td>
													<td>
													Paid
													</td>
												</tr>
												</tbody>
											</table>
											</div>
										</div>';
	if ( $type == 'invoice' ) {
		$html .= '<div id="detail-to">
					<table class="invoice-title-to-mwbpdf">
					<thead class="background-pdf-color-template">
						<tr>
						<th>
							BILL TO
						</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>' . $order_billing_arr['billing_full_name'] . '</td>
						</tr>
						<tr>
							<td>' . $order_billing_arr['billing_address_1'] . ' ' . $order_billing_arr['billing_address_2'] . '</td>
						</tr>
						<tr>
							<td>' . $order_billing_arr['billing_city'] . ' ' . $order_billing_arr['billing_state'] . ' ' . $order_billing_arr['billing_postcode'] . '</td>
						</tr>
						<tr>
							<td>' . $order_billing_arr['billing_phone'] . '</td>
						</tr>
						<tr>
							<td>' . $order_billing_arr['billing_email'] . '</td>
						</tr>
					</tbody>
					</table>
				</div>';
	} else {
		$html .= '<div id="detail-to">
					<table class="invoice-title-to-mwbpdf">
					<thead class="background-pdf-color-template">
						<tr>
						<th>
							SHIP TO
						</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>' . $order_shipping_arr['shipping_full_name'] . '</td>
						</tr>
						<tr>
							<td>' . $order_shipping_arr['shipping_address_1'] . ' ' . $order_shipping_arr['shipping_address_2'] . '</td>
						</tr>
						<tr>
							<td>' . $order_shipping_arr['shipping_city'] . ' ' . $order_shipping_arr['shipping_state'] . ' ' . $order_shipping_arr['shipping_postcode'] . '</td>
						</tr>
						<tr>
							<td>' . $order_billing_arr['billing_phone'] . '</td>
						</tr>
						<tr>
							<td>' . $order_billing_arr['billing_email'] . '</td>
						</tr>
					</tbody>
					</table>
				</div>';
	}
	$html   .= '<div>
					<table id="my-table-mwb-prod-listing">
					<thead class="background-pdf-color-template">
						<tr>
						<th>
							Name
						</th>
						<th>
							Qty
						</th>
						<th>
							Unit Price
						</th>
						<th>
							Tax
						</th>
						<th>
							Total
						</th>
						</tr>
					</thead>
				<tbody>';
	foreach ( $order_item_arr as $product ) {
		$html .= '<tr>
					<td>' . $product["prod_name"] . '</td>
					<td>' . $product["quantity"] . '</td>
					<td>' . $product["sub_total"] . '</td>
					<td>' . array_shift( array_shift( $product["percent_tax"] ) ) . '</td>
					<td>' . $product["total"] . '</td>
				</tr>';
	}
	$html .= '<tr><td colspan="3">' . $disclaimer . '</td><td>Subtotal</td><td>525.00</td></tr>
			<tr><td colspan="3"class="no-border"></td><td>Tax Rate</td><td>4.250%</td></tr>
			<tr><td colspan="3" class="no-border"></td><td>Tax</td><td>22.31</td></tr>
			<tr><td colspan="3" class="no-border"></td><td>Total</td><td>$ 547.31</td></tr>
			</tbody>
			</table>
			</div>
		</div>
		</form>
	</div>
	</body>
</html>';
	return $html;
}
