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
	$order_details         = do_shortcode( '[isfw_fetch_order order_id ="' . $order_id . '"]' );
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
		$is_add_logo     = array_key_exists( 'is_add_logo', $isfw_pdf_settings ) ? $isfw_pdf_settings['is_add_logo'] : '';
	} else {
		$prefix          = '';
		$suffix          = '';
		$digit           = 3;
		$logo            = '';
		$date            = '';
		$disclaimer      = 'Thank you for shopping with us.';
		$color           = '#000000';
		$company_name    = '';
		$company_address = '';
		$company_city    = '';
		$company_state   = '';
		$company_pin     = '';
		$company_phone   = '';
		$company_email   = '';
		$is_add_logo     = '';
	}
	if ( '' !== $date ) {
		if ( gmdate( 'Y-m-d', strtotime( $date ) ) <= gmdate( 'Y-m-d' ) ) {
			update_option( 'isfw_current_invoice_id', 1 );
		}
	}
	$prev_invoice_id = get_option( 'isfw_current_invoice_id', true );
	if ( $prev_invoice_id ) {
		$curr_invoice_id = $prev_invoice_id + 1;
		update_option( 'isfw_current_invoice_id', $curr_invoice_id );
	} else {
		$curr_invoice_id = 1;
		update_option( 'isfw_current_invoice_id', 1 );
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
	// generating invoice number.
	$invoice_number = str_pad( $curr_invoice_id, $digit, '0', STR_PAD_LEFT );
	$invoice_id     = $prefix . $invoice_number . $suffix;
	if ( $order_details ) {
		$html = '<!DOCTYPE html>
							<html lang="en">
							<head>
								<style>
									.isfw-invoice-background-color{
										background-color: #f5f5f5;
									}
									.isfw-invoice-color{
										color: ' . $color . ';
									}
									#mwb-pdf-form{
										font-family: DejaVu Sans !important;
									}
								</style>
							</head>
							<body>
								<div id="mwb-pdf-form">
									<form action="" method="post">';
		if ( 'yes' === $is_add_logo && '' !== $logo ) {
			$html .= '<div style="text-align:center;margin-bottom: 30px;"><img src="' . $logo . '" height="120" width="120"></div>';
		}
				$html .= '<table border = "0" cellpadding = "0" cellspacing = "0" style="width: 100%; vertical-align: top; margin-bottom: 30px;">
											<tbody>
												<tr>
													<td valign="top">
														<table border = "0" cellpadding = "0" cellspacing = "0" style="width: 100%;"> 
															<tbody>
																<tr>
																	<td class="isfw-invoice-background-color" style="padding: 10px;">
																		<h3 class="isfw-invoice-color" style="margin: 0;font-size: 24px;">' . $company_name . '</h3>
																	</td>
																</tr>
																<tr>
																	<td style="padding: 5px 10px;">' . ucfirst( $company_address ) . '</td>
																</tr>
																<tr>
																	<td style="padding: 5px 10px;">' . ucfirst( $company_city ) . ',<br/> ' . ucfirst( $company_state ) . ',<br/> ' . $company_pin . '</td>
																</tr>
																<tr>
																	<td style="padding: 5px 10px;">Phone : ' . $company_phone . '</td>
																</tr>
																<tr>
																	<td style="padding: 5px 10px;">Email : ' . $company_email . '</td>
																</tr>
															</tbody>
														</table>
													</td>
													<td valign="top">
														<table border = "0" cellpadding = "0" cellspacing = "0" class="" style="width: 100%;table-layout: auto;">
															<thead>
																<tr>
																	<th colspan="2" class="isfw-invoice-background-color" style="padding: 10px;">
																		<h3 class="isfw-invoice-color" style="margin: 0;text-align:right;font-size:24px;">
																			' . __( 'Invoice', 'invoice-system-for-woocommerce' ) . '
																		</h3>
																	</th>
																</tr>
																<tr>
																	<th style="width: 70%;text-align: right;padding: 10px;">
																		' . __( 'Invoice', 'invoice-system-for-woocommerce' ) . '
																	</th>
																	<th style="width: 30%;text-align: right;padding: 10px;">
																		' . __( 'Date', 'invoice-system-for-woocommerce' ) . '
																	</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td style="width: 30%;text-align: right;padding: 0 10px;">' . $invoice_id . '</td>
																	<td style="width: 30%;text-align: right;padding: 0 10px;">' . $billing_details['order_created_date'] . '</td>
																</tr>
															</tbody>
														</table>
														<table border = "0" class="" style="width: 100%;table-layout: auto;">
															<thead>
																<tr>
																	<th style="width: 70%;text-align: right;padding: 10px;">
																		' . __( 'Customer ID', 'invoice-system-for-woocommerce' ) . '
																	</th>
																	<th style="width: 30%;text-align: right;padding: 10px;">
																		' . __( 'Status', 'invoice-system-for-woocommerce' ) . '
																	</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td class="" style="width: 70%;text-align: right;padding: 0 10px;">
																		' . $billing_details['customer_id'] . '
																	</td>
																	<td class="" style="width: 30%;text-align: right;padding: 0 10px;">
																		' . $shipping_details['order_status'] . '
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
									<th class="isfw-invoice-background-color isfw-invoice-color" style="text-align:left;padding:10px;font-size: 20px;">
										' . __( 'BILL TO', 'invoice-system-for-woocommerce' ) . '
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="padding: 2px 10px;font-weight: bold;font-size: 18px;">' . ucfirst( $billing_details['billing_first_name'] ) . ' ' . ucfirst( $billing_details['billing_last_name'] ) . '</td>
								</tr>
								<tr>
									<td style="padding: 2px 10px;font-size: 16px;">' . ucfirst( $billing_details['billing_address_1'] ) . ' ' . ucfirst( $billing_details['billing_address_2'] ) . '</td>
								</tr>
								<tr>
									<td style="padding: 2px 10px;font-size: 16px;">' . ucfirst( $billing_details['billing_city'] ) . ', ' . ucfirst( $billing_details['billing_state'] ) . ', ' . $billing_details['billing_postcode'] . '</td>
								</tr>
								<tr>
									<td style="padding: 2px 10px;font-size: 16px;">' . $billing_details['billing_phone'] . '</td>
								</tr>
								<tr>
									<td style="padding: 2px 10px;font-size: 16px;">' . $billing_details['billing_email'] . '</td>
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
									<th class="isfw-invoice-background-color isfw-invoice-color" style="text-align:left;padding:10px;font-size:20px;">
										' . __( 'SHIP TO', 'invoice-system-for-woocommerce' ) . '
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="padding: 2px 10px;font-weight: bold;font-size: 18px;">' . ucfirst( $shipping_details['shipping_first_name'] ) . ' ' . ucfirst( $shipping_details['shipping_last_name'] ) . '</td>
								</tr>
								<tr>
									<td style="padding: 2px 10px;font-size: 16px;">' . ucfirst( $shipping_details['shipping_address_1'] ) . ' ' . ucfirst( $shipping_details['shipping_address_2'] ) . '</td>
								</tr>
								<tr>
									<td style="padding: 2px 10px;font-size: 16px;">' . ucfirst( $shipping_details['shipping_city'] ) . ', ' . ucfirst( $shipping_details['shipping_state'] ) . ', ' . $shipping_details['shipping_postcode'] . '</td>
								</tr>
								<tr>
									<td style="padding: 2px 10px;font-size: 16px;">' . $billing_details['billing_phone'] . '</td>
								</tr>
								<tr>
									<td style="padding: 2px 10px;font-size: 16px;">' . $billing_details['billing_email'] . '</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>';
		}
		if ( 'invoice' === $type ) {
			$html .= '<table border = "0" cellpadding = "0" cellspacing = "0" style="width: 100%; vertical-align: top;text-align: left;" id="my-table-mwb-prod-listing">
					<thead class="background-pdf-color-template">
						<tr class="isfw-invoice-background-color">
							<th style="text-align: left;padding: 10px;" class="isfw-invoice-color">
								' . __( 'Name', 'invoice-system-for-woocommerce' ) . '
							</th>
							<th style="text-align: left;padding: 10px;" class="isfw-invoice-color">
								' . __( 'Qty', 'invoice-system-for-woocommerce' ) . '
							</th>
							<th style="text-align: left;padding: 10px;" class="isfw-invoice-color">
								' . __( 'Unit Price', 'invoice-system-for-woocommerce' ) . ' ( ' . $billing_details['order_currency'] . ' )
							</th>
							<th style="text-align: left;padding: 10px;" class="isfw-invoice-color">
								' . __( 'Tax', 'invoice-system-for-woocommerce' ) . '( % )
							</th>
							<th style="text-align: left;padding: 10px;" class="isfw-invoice-color">
								' . __( 'Total', 'invoice-system-for-woocommerce' ) . ' ( ' . $billing_details['order_currency'] . ' )
							</th>
						</tr>
					</thead>
					<tbody>';
			foreach ( $order_product_details as $key => $product ) {
				$style = ( 0 !== $key % 2 ) ? 'class="isfw-invoice-background-color"' : '';
				$html .= '<tr ' . $style . '>
								<td style="text-align: left;padding: 10px;">' . $product['product_name'] . '</td>
								<td style="text-align: left;padding: 10px;">' . $product['product_quantity'] . '</td>
								<td style="text-align: left;padding: 10px;">' . $product['product_price'] . '</td>
								<td style="text-align: left;padding: 10px;">' . $product['tax_percent'] . '</td>
								<td style="text-align: left;padding: 10px;">' . $product['product_total'] . '</td>
							</tr>';
			}
			$html .= '<tr>
						<td colspan="3" style="padding: 2px 10px;font-weight: bold;">
						</td>
						<td style="padding: 2px 10px;font-weight: bold;">
						' . __( 'Subtotal', 'invoice-system-for-woocommerce' ) . '</td>
						<td style="padding: 2px 10px;font-weight: bold;">
							' . $billing_details['order_subtotal'] . '
						</td>
					</tr>
					<tr>
						<td colspan="3" style="padding: 2px 10px;font-weight: bold;" class="no-border">

						</td>
						<td style="padding: 2px 10px;font-weight: bold;">
							' . __( 'Shipping', 'invoice-system-for-woocommerce' ) . '
						</td>
						<td style="padding: 2px 10px;font-weight: bold;">
							' . $shipping_details['shipping_total'] . '
						</td>
					</tr>
					<tr>
						<td colspan="3" style="padding: 2px 10px;font-weight: bold;" class="no-border">

						</td>
						<td style="padding: 2px 10px;font-weight: bold;">
							' . __( 'Total Tax', 'invoice-system-for-woocommerce' ) . '
						</td>
						<td style="padding: 2px 10px;font-weight: bold;">
							' . $billing_details['tax_totals'] . '
						</td>
					</tr>
					<tr>
						<td colspan="3" style="padding: 2px 10px;font-weight: bold;" class="no-border">

						</td>
						<td style="padding: 2px 10px;font-weight: bold;">
							' . __( 'Total', 'invoice-system-for-woocommerce' ) . ' ( ' . $billing_details['order_currency'] . ' ) 
						</td>
						<td style="padding: 2px 10px;font-weight: bold;">
							' . $billing_details['cart_total'] . '
						</td>
					</tr>
				</tbody>
			</table>
			<div style="margin-top: 30px;font-size: 24px;padding: 10px;text-align: center;">
				' . $disclaimer . '
			</div>';
		}
		$html .= '</form>
				</div>
			</body>
		</html>';
		return $html;
	}
	return '<div>' . esc_html_e( 'Looks like order is not found', 'invoice-system-for-woocommerce' ) . '</div>';
}
