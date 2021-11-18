<?php
/**
 * This is template one for the pdf generation.
 *
 * @package Invoice_system_for_woocommere.
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
	$digit                 = get_option( 'isfw_invoice_number_digit' );
	$prefix                = get_option( 'isfw_invoice_number_prefix' );
	$suffix                = get_option( 'isfw_invoice_number_suffix' );
	$date                  = get_option( 'isfw_invoice_renew_date' );
	$disclaimer            = get_option( 'isfw_invoice_disclaimer' );
	$color                 = get_option( 'isfw_invoice_color' );
	$is_add_logo           = get_option( 'isfw_is_add_logo_invoice' );
	$logo                  = get_option( 'sub_isfw_upload_invoice_company_logo' );
	$digit                 = ( $digit ) ? $digit : 3;
	$color                 = ( $color ) ? $color : '#000000';
	if ( $order_details ) {
		$html = '<!DOCTYPE html>
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
							#isfw-pdf{
								font-family: DejaVu Sans !important;
							}
						</style>
					</head>
					<body>
						<div id="isfw-pdf">
							<h2 id="isfw-invoice-text">
							' . __( 'INVOICE', 'invoice-system-for-woocommerce' ) . '
							</h2>
							<div id="isfw-pdf-header">
								<div id="isfw-invoice-title-left" class="isfw-invoice-inline">
									<div>
										<b>' . __( 'Invoice Number', 'invoice-system-for-woocommerce' ) . '</b><br/>
										' . $invoice_id . '
									</div>
									<div>
										<b>' . __( 'Date', 'invoice-system-for-woocommerce' ) . '</b><br/>
										' . $billing_details['order_created_date'] . '
									</div>
								</div>
								<div id="isfw-invoice-title-right" class="isfw-invoice-inline">
									<div>';
		if ( 'yes' === $is_add_logo && '' !== $logo ) {
			$html .= '<img src="' . $logo . '" height="120" width="120"><br/>';
		}
		if ( $company_name ) {
			$html .= '<b>' . ucfirst( $company_name ) . '</b><br/>';
		}
		if ( $company_address ) {
			$html .= ucfirst( $company_address ) . ' ,';
		}
		if ( $company_city ) {
			$html .= ucfirst( $company_city ) . '<br/>';
		}
		if ( $company_state ) {
			$html .= ucfirst( $company_state );
		}
		if ( $company_pin ) {
			$html .= '<br/> ' . $company_pin . '<br/>';
		}
		if ( $company_phone ) {
			$html .= $company_phone . '<br/>';
		}
		if ( $company_email ) {
			$html .= $company_email;
		}
		$html .= '</div>
			</div>
		</div>';
		if ( 'invoice' === $type ) {
			$html .= '<div id="isfw-invoice-title-to" >
						<b>' . __( 'Invoice to', 'invoice-system-for-woocommerce' ) . '</b><br/>
						<div>
							' . ucfirst( $billing_details['billing_first_name'] ) . ' ' . ucfirst( $billing_details['billing_last_name'] ) . '<br/>';
			if ( $billing_details['billing_company'] ) {
				$html .= $billing_details['billing_company'] . '<br/>';
			}
			if ( $billing_details['billing_address_1'] ) {
				$html .= ucfirst( $billing_details['billing_address_1'] ) . ' ' . ucfirst( $billing_details['billing_address_2'] ) . '<br/>';
			}
			if ( $billing_details['billing_city'] ) {
				$html .= ucfirst( $billing_details['billing_city'] ) . '<br/>';
			}
			if ( $billing_details['billing_state'] ) {
				$html .= ucfirst( $billing_details['billing_state'] ) . '<br/>';
			}
			if ( $billing_details['billing_postcode'] ) {
				$html .= $billing_details['billing_postcode'] . '<br/>';
			}
			if ( $billing_details['billing_phone'] ) {
				$html .= $billing_details['billing_phone'] . '<br/>';
			}
			if ( $billing_details['billing_email'] ) {
				$html .= $billing_details['billing_email'] . '<br/>';
			}
			$html .= '</div>
			</div>';
		} else {
			$html .= '<div id="isfw-invoice-title-to" >
						<b>' . __( 'SHIP TO', 'invoice-system-for-woocommerce' ) . '</b><br/>
						<div>
							' . ucfirst( $shipping_details['shipping_first_name'] ) . ' ' . ucfirst( $shipping_details['shipping_last_name'] ) . '<br/>';
			if ( $shipping_details['shipping_company'] ) {
				$html .= $shipping_details['shipping_company'] . '<br/>';
			}
			if ( $shipping_details['shipping_address_1'] ) {
				$html .= ucfirst( $shipping_details['shipping_address_1'] ) . ' ' . ucfirst( $shipping_details['shipping_address_2'] ) . '<br/>';
			}
			if ( $shipping_details['shipping_city'] ) {
				$html .= ucfirst( $shipping_details['shipping_city'] ) . '<br/>';
			}
			if ( $shipping_details['shipping_state'] ) {
				$html .= ucfirst( $shipping_details['shipping_state'] ) . '<br/>';
			}
			if ( $shipping_details['shipping_postcode'] ) {
				$html .= $shipping_details['shipping_postcode'] . '<br/>';
			}
			if ( $billing_details['billing_phone'] ) {
				$html .= $billing_details['billing_phone'] . '<br/>';
			}
			if ( $billing_details['billing_email'] ) {
				$html .= $billing_details['billing_email'] . '<br/>';
			}
			$html .= '</div>
					</div>';
		}
		if ( 'invoice' === $type ) {
			$html .= '<div>
						<table border = "0" cellpadding = "0" cellspacing = "0" id="isfw-prod-listing-table">
							<thead>
								<tr id="isfw-prod-listing-table-title">
									<th id="isfw-table-items">' . __( 'Items', 'invoice-system-for-woocommerce' ) . '</th>
									<th>' . __( 'Quantity', 'invoice-system-for-woocommerce' ) . '</th>
									<th>' . __( 'Price', 'invoice-system-for-woocommerce' ) . '(' . $billing_details['order_currency'] . ')</th>
									<th>' . __( 'Tax', 'invoice-system-for-woocommerce' ) . ' (%)</th>
									<th>' . __( 'Amount', 'invoice-system-for-woocommerce' ) . '(' . $billing_details['order_currency'] . ')</th>
								</tr>
							</thead>
							<tbody id="isfw-pdf-prod-body">';
			$meta_data = '';
			foreach ( $order_product_details as $product ) {
				$item_data = ! empty( $product['item_meta'] ) ? $product['item_meta'] : array();
				if ( ! empty( $item_data ) && is_array( $item_data ) ) {
					foreach ( $item_data as $key => $item ) {
						
						if ( 'is_upsell_purchase' === $item['display_key'] ) {
							continue;
						}

						$meta_data .= '<br/>' . $item['display_key'] . ':' . $item['display_value'];
					}
				}
				$html .= '<tr>
						<td class="isfw-product-name">' . $product['product_name'] . $meta_data . '</td>
						<td>' . $product['product_quantity'] . '</td>
						<td>' . $product['product_price'] . '</td>
						<td>' . $product['tax_percent'] . '</td>
						<td>' . $product['product_total'] . '</td>
					</tr>';
			}
			$html               .= '</tbody>
										</table>
										<div id="isfw-prod-listing-table-bottom"></div>
										<div id="isfw-prod-total-calc">
											<table border = "0" cellpadding = "0" cellspacing = "0">
												<tr>
													<td>' . __( 'Payment via', 'invoice-system-for-woocommerce' ) . ' : ' . $billing_details['payment_method'] . '</td>
												</tr>
												<tr>
													<td>' . __( 'Subtotal', 'invoice-system-for-woocommerce' ) . '(' . $billing_details['order_currency'] . '): ' . $billing_details['order_subtotal'] . '</td>
												</tr>
												<tr>
													<td>' . __( 'Shipping', 'invoice-system-for-woocommerce' ) . '(' . $billing_details['order_currency'] . '): ' . $shipping_details['shipping_total'] . '</td>
												</tr>
												<tr>
													<td>' . __( 'Total tax', 'invoice-system-for-woocommerce' ) . '(' . $billing_details['order_currency'] . '): ' . $billing_details['tax_totals'] . '</td>
												</tr>';
			$isfw_coupon_details = $billing_details['coupon_details'];
			foreach ( $isfw_coupon_details as $key => $price ) {
				$html .= '<tr>
							<td>' . $key . '(' . $billing_details['order_currency'] . '): ' . $price . '</td>
						</tr>';
			}
			$html .= '<tr>
								<td>' . __( 'Total', 'invoice-system-for-woocommerce' ) . '(' . $billing_details['order_currency'] . '): ' . $billing_details['cart_total'] . '</td>
							</tr>
						</table>
					</div>
					<div class="isfw-invoice-greetings">
						<b>' . $disclaimer . '</b>
					</div>
					</div>';
		}
		$html .= '</div>
				</body>
			</html>';
		return $html;
	}
	return '<div>' . esc_html__( 'Looks like order is not found', 'invoice-system-for-woocommerce' ) . '</div>';
}
