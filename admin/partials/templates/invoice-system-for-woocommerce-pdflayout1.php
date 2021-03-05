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
 * @return string
 */
function return_ob_value( $order_id ) {
	$order           = wc_get_order( $order_id );
	$billing_details = array(
		'billing_name'     => $order->get_billing_first_name() . $order->get_billing_last_name(),
		'billing_company'  => $order->get_billing_company(),
		'billing_address'  => $order->get_billing_address_1() . $order->get_billing_address_2(),
		'billing_city'     => $order->get_billing_city(),
		'billing_state'    => $order->get_billing_state(),
		'billing_postcode' => $order->get_billing_postcode(),
		'billing_country'  => $order->get_billing_country(),
		'billing_phone'    => $order->get_billing_phone(),
		'billing_email'    => $order->get_billing_email(),

	);

	$html = '<!DOCTYPE html>
	<html lang="en">
		<head>
			<style>
					#company-details-mwbpdf-builder{
							cursor: pointer;
					}
					.pdf-color-template{
							color: #000000;
					}
					#invoice-mwbpdf-builder{
							cursor: pointer;
							margin-left: 500px;
							position: relative;
							top: -120px;
					}
					#header-first, #detail-to{
							overflow: hidden;
					}
					.invoice-title-to-mwbpdf{
							cursor: pointer;
					}
					#detail-to{
							overflow: hidden;
							position: relative;
							top: -120px;
					}
					.background-pdf-color-template{
							color: white;
							background-color:#000000;
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
						2034
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
			</div>
			<div id="detail-to">
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
						<td>' . $billing_details['billing_name'] . '</td>
					</tr>
					<tr>
						<td>' . $billing_details['billing_company'] . '</td>
					</tr>
					<tr>
						<td>' . $billing_details['billing_address'] . '</td>
					</tr>
					<tr>
						<td>' . $billing_details['billing_state'] . $billing_details['billing_city'] . $billing_details['billing_postcode'] . '</td>
					</tr>
					<tr>
						<td>' . $billing_details['billing_phone'] . '</td>
					</tr>
					<tr>
						<td>' . $billing_details['billing_email'] . '</td>
					</tr>
				</tbody>
				</table>
			</div>
			<div>
				<table id="my-table-mwb-prod-listing">
				<thead class="background-pdf-color-template">
					<tr>
					<th>
						Description
					</th>
					<th>
						Qty
					</th>
					<th>
						Unit Price
					</th>
					<th>
						Amount
					</th>
					</tr>
				</thead>
				<tbody>
					<tr>
					<td>
						Product 1
					</td>
					<td>
						2
					</td>
					<td>
						100
					</td>
					<td>
						200
					</td>
					</tr>
					<tr><td colspan="2">Thank you for your business.</td><td>Subtotal</td><td>525.00</td></tr>
					<tr><td colspan="2"class="no-border"></td><td>Tax Rate</td><td>4.250%</td></tr>
					<tr><td colspan="2" class="no-border"></td><td>Tax</td><td>22.31</td></tr>
					<tr><td colspan="2" class="no-border"></td><td>Total</td><td>$ 547.31</td></tr>
				</tbody>
				</table>
				</div>
				<div>
				If you have any query feel free to ask us.
				</div>
			</div>
			</form>
		</div>
		</body>
	</html>';
	return $html;
}
