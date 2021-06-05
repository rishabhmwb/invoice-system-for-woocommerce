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
 * @param string $invoice_id current invoice ID.
 * @return string
 */
function return_ob_value( $order_id, $type, $invoice_id ) {
	$order_details         = do_shortcode( '[ISFW_FETCH_ORDER order_id ="' . $order_id . '"]' );
	$order_details         = json_decode( $order_details, true );
	$shipping_details      = $order_details['shipping_details'];
	$billing_details       = $order_details['billing_details'];
	$order_product_details = $order_details['product_details'];
	$company_name          = get_option( 'isfw_company_name' );
	$company_address       = get_option( 'isfw_company_address' );
	$company_city          = get_option( 'isfw_company_city' );
	$company_state         = get_option( 'isfw_company_state' );
	$company_pin           = get_option( 'isfw_company_pin' );
	$company_phone         = get_option( 'isfw_company_phone' );
	$company_email         = get_option( 'isfw_company_email' );
	$disclaimer            = get_option( 'isfw_invoice_disclaimer' );
	$color                 = get_option( 'isfw_invoice_color' );
	$is_add_logo           = get_option( 'isfw_is_add_logo_invoice' );
	$logo                  = get_option( 'sub_isfw_upload_invoice_company_logo' );
	$color                 = ( $color ) ? $color : '#000000';
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
										</tr>';
		if ( $company_address ) {
			$html .= '<tr>
				<td style="padding: 5px 10px;">' . ucfirst( $company_address ) . '</td>
			</tr>';
		}
		$html .= '<tr>
					<td style="padding: 5px 10px;">';
		if ( $company_city ) {
			$html .= ucfirst( $company_city );
		}
		if ( $company_state ) {
			$html .= '<br/> ' . ucfirst( $company_state );
		}
		if ( $company_pin ) {
			$html .= '<br/> ' . $company_pin;
		}
		$html = '</td>
				</tr>';
		if ( $company_phone ) {
			$html .= '<tr>
						<td style="padding: 5px 10px;">Phone : ' . $company_phone . '</td>
					</tr>';
		}
		if ( $company_email ) {
			$html .= '<tr>
						<td style="padding: 5px 10px;">Email : ' . $company_email . '</td>
					</tr>';
		}
		$html .= '</tbody>
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
								</tr>';
			if ( $billing_details['billing_company'] ) {
				$html .= '<tr>
							<td style="padding: 2px 10px;font-size: 16px;">' . ucfirst( $billing_details['billing_company'] ) . '</td>
						</tr>';
			}
			if ( $billing_details['billing_address_1'] ) {
				$html .= '<tr>
							<td style="padding: 2px 10px;font-size: 16px;">' . ucfirst( $billing_details['billing_address_1'] ) . ' ' . ucfirst( $billing_details['billing_address_2'] ) . '</td>
						</tr>';
			}
			if ( $billing_details['billing_city'] ) {
				$html .= '<tr>
							<td style="padding: 2px 10px;font-size: 16px;">' . ucfirst( $billing_details['billing_city'] ) . ', ' . ucfirst( $billing_details['billing_state'] ) . ', ' . $billing_details['billing_postcode'] . '</td>
						</tr>';
			}
			if ( $billing_details['billing_phone'] ) {
				$html .= '<tr>
							<td style="padding: 2px 10px;font-size: 16px;">' . $billing_details['billing_phone'] . '</td>
						</tr>';
			}
			if ( $billing_details['billing_email'] ) {
				$html .= '<tr>
							<td style="padding: 2px 10px;font-size: 16px;">' . $billing_details['billing_email'] . '</td>
						</tr>';
			}
			$html .= '</tbody>
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
									</tr>';
			if ( $billing_details['billing_company'] ) {
				$html .= '<tr>
							<td style="padding: 2px 10px;font-size: 16px;">' . ucfirst( $billing_details['billing_company'] ) . '</td>
						</tr>';
			}
			if ( $shipping_details['shipping_address_1'] ) {
				$html .= '<tr>
							<td style="padding: 2px 10px;font-size: 16px;">' . ucfirst( $shipping_details['shipping_address_1'] ) . ' ' . ucfirst( $shipping_details['shipping_address_2'] ) . '</td>
						</tr>';
			}
			if ( $shipping_details['shipping_city'] ) {
				$html .= '<tr>
							<td style="padding: 2px 10px;font-size: 16px;">' . ucfirst( $shipping_details['shipping_city'] ) . ', ' . ucfirst( $shipping_details['shipping_state'] ) . ', ' . $shipping_details['shipping_postcode'] . '</td>
						</tr>';
			}
			if ( $billing_details['billing_phone'] ) {
				$html .= '<tr>
							<td style="padding: 2px 10px;font-size: 16px;">' . $billing_details['billing_phone'] . '</td>
						</tr>';
			}
			if ( $billing_details['billing_email'] ) {
				$html .= '<tr>
							<td style="padding: 2px 10px;font-size: 16px;">' . $billing_details['billing_email'] . '</td>
						</tr>';
			}
			$html .= '</tbody>
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
