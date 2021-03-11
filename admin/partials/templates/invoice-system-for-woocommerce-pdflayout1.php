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
							</style>
						</head>
						<body>
							<div id="mwb-pdf-form">
								<form action="" method="post">
									<table border = "0" cellpadding = "0" cellspacing = "0" style="width: 100%; vertical-align: top; margin-bottom: 30px;">
										<tbody>
											<tr>
												<td valign="top">
													<table border = "0" cellpadding = "0" cellspacing = "0" style="width: 100%;"> 
														<tbody>
															<tr>
																<td style="background: #f5f5f5;padding: 10px;">
																	<h3 style="margin: 0;color: #dd5e49;font-size: 24px;">Company</h3>
																</td>
						
															</tr>
															<tr>
																<td style="padding: 5px 10px;">Vikash khand</td>
															</tr>
															<tr>
																<td style="padding: 5px 10px;">Lucknow,<br/> 226010</td>
															</tr>
															<tr>
																<td style="padding: 5px 10px;">Phone : [000] 000-000</td>
															</tr>
														</tbody>
													</table>
												</td>
												<td valign="top">
													<table border = "0" cellpadding = "0" cellspacing = "0" class="" style="width: 100%;table-layout: auto;">
														<thead>
															<tr>
																<th colspan="2" style="background: #f5f5f5;padding: 10px;">
																	<h3 style="margin: 0; text-align: right;color: #dd5e49;font-size: 24px;">
																		Invoice
																	</h3>
																</th>
															</tr>
															<tr>
																<th style="width: 70%;text-align: right;padding: 10px;">
																	Invoice
																</th>
																<th style="width: 30%;text-align: right;padding: 10px;">
																	Date
																</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td style="width: 30%;text-align: right;padding: 0 10px;">' . $invoice_id . '</td>
																<td style="width: 30%;text-align: right;padding: 0 10px;">' . $billing_details["order_created_date"] . '</td>
															</tr>
														</tbody>
													</table>
													<table border = "0" class="" style="width: 100%;table-layout: auto;">
														<thead>
															<tr>
																<th class="" style="width: 70%;text-align: right;padding: 10px;">
																	Customer ID
																</th>
																<th class="" style="width: 30%;text-align: right;padding: 10px;">
																	Terms
																</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td class="" style="width: 70%;text-align: right;padding: 0 10px;">
																	564
																</td>
																<td class="" style="width: 30%;text-align: right;padding: 0 10px;">
																	Paid
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>';
	if ( 'invoice' === $type ) {
		$html .= '<tr>
				<td colspan="2">
					<table border = "0" cellpadding="0" cellpadding="0" style="width: 100%;margin-top: 20px;">
						<thead>
							<tr>
								<th style="text-align: left;background: #f5f5f5;padding: 10px;color: #dd5e49;font-size: 20px;">
									BILL TO
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="padding: 2px 10px;font-weight: bold;font-size: 18px;">' . $billing_details["billing_first_name"] . $billing_details["billing_last_name"] . '</td>
							</tr>
							<tr>
								<td style="padding: 2px 10px;font-size: 16px;">' . $billing_details["billing_address_1"] . ' ' . $billing_details["billing_address_2"] . '</td>
							</tr>
							<tr>
								<td style="padding: 2px 10px;font-size: 16px;">' . $billing_details["billing_city"] . ', ' . $billing_details["billing_state"] . ', ' . $billing_details["billing_postcode"] . '</td>
							</tr>
							<tr>
								<td style="padding: 2px 10px;font-size: 16px;">' . $billing_details["billing_phone"] . '</td>
							</tr>
							<tr>
								<td style="padding: 2px 10px;font-size: 16px;">' . $billing_details["billing_email"] . '</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>';
	} else {
		$html .= '<tr>
				<td colspan="2">
					<table border = "0" cellpadding="0" cellpadding="0" style="width: 100%;margin-top: 20px;">
						<thead>
							<tr>
								<th style="text-align: left;background: #f5f5f5;padding: 10px;color: #dd5e49;font-size: 20px;">
									SHIP TO
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="padding: 2px 10px;font-weight: bold;font-size: 18px;">' . $shipping_details["shipping_first_name"] . $shipping_details["shipping_last_name"] . '</td>
							</tr>
							<tr>
								<td style="padding: 2px 10px;font-size: 16px;">' . $shipping_details["shipping_address_1"] . ' ' . $shipping_details["shipping_address_2"] . '</td>
							</tr>
							<tr>
								<td style="padding: 2px 10px;font-size: 16px;">' . $shipping_details["shipping_city"] . ', ' . $shipping_details["shipping_state"] . ', ' . $shipping_details["shipping_postcode"] . '</td>
							</tr>
							<tr>
								<td style="padding: 2px 10px;font-size: 16px;">' . $billing_details["billing_phone"] . '</td>
							</tr>
							<tr>
								<td style="padding: 2px 10px;font-size: 16px;">' . $billing_details["billing_email"] . '</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>';
	}
	$html .= '<table border = "0" cellpadding = "0" cellspacing = "0" style="width: 100%; vertical-align: top;text-align: left;" id="my-table-mwb-prod-listing">
			<thead class="background-pdf-color-template">
				<tr style="background: #f5f5f5;">
					<th style="text-align: left;padding: 10px;color: #dd5e49;">
						Name
					</th>
					<th style="text-align: left;padding: 10px;color: #dd5e49;">
						Qty
					</th>
					<th style="text-align: left;padding: 10px;color: #dd5e49;">
						Unit Price
					</th>
					<th style="text-align: left;padding: 10px;color: #dd5e49;">
						Tax
					</th>
					<th style="text-align: left;padding: 10px;color: #dd5e49;">
						Total
					</th>
				</tr>
			</thead>
			<tbody>';
	foreach ( $order_product_details as $key => $product ) {
		$style = ( $key % 2 != 0 ) ?  'style="background: #fff6ee";' : '';
		$html .= '<tr ' . $style . '>
						<td style="text-align: left;padding: 10px;">' . $product["product_name"] . '</td>
						<td style="text-align: left;padding: 10px;">' . $product["product_quantity"] . '</td>
						<td style="text-align: left;padding: 10px;">' . $product["product_price"] . '</td>
						<td style="text-align: left;padding: 10px;">' . $product["tax_percent"] . '</td>
						<td style="text-align: left;padding: 10px;">' . $product["product_total"] . '</td>
					</tr>';
	}
		$html .= '<tr>
					<td colspan="3" style="padding: 2px 10px;font-weight: bold;">
					</td>
					<td style="padding: 2px 10px;font-weight: bold;">
					Subtotal</td>
					<td style="padding: 2px 10px;font-weight: bold;">
						' . $billing_details["order_subtotal"] . '
					</td>
				</tr>
				<tr>
					<td colspan="3" style="padding: 2px 10px;font-weight: bold;" class="no-border">

					</td>
					<td style="padding: 2px 10px;font-weight: bold;">
						Shipping
					</td>
					<td style="padding: 2px 10px;font-weight: bold;">
						' . $shipping_details["shipping_total"] . '
					</td>
				</tr>
				<tr>
					<td colspan="3" style="padding: 2px 10px;font-weight: bold;" class="no-border">

					</td>
					<td style="padding: 2px 10px;font-weight: bold;">
						Total Tax
					</td>
					<td style="padding: 2px 10px;font-weight: bold;">
						' . $billing_details["tax_totals"] . '
					</td>
				</tr>
				<tr>
					<td colspan="3" style="padding: 2px 10px;font-weight: bold;" class="no-border">

					</td>
					<td style="padding: 2px 10px;font-weight: bold;">
						Total
					</td>
					<td style="padding: 2px 10px;font-weight: bold;">
						' . $billing_details["cart_total"] . '
					</td>
				</tr>
			</tbody>
		</table>
		<div style="margin-top: 30px;font-size: 24px;padding: 10px;text-align: center;">
			' . $disclaimer . '
		</div>
	</form>
</div>
</body>
</html>';
	return $html;
}
