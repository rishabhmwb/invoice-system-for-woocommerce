<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Invoice_system_for_woocommere
 * @subpackage Invoice_system_for_woocommere/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Main file for generating pdf using dompdf.
 *
 * @package makewebbetter.com
 */
require INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_PATH . 'package/lib/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$html   = '<!DOCTYPE html>
				<html>
				<head>
					<title> INVOICE SYSTEM FOR WOOCOMMERCE </title>
				<style>
					#isfw-invoice-title-right{
						margin-left: 500px;
						position: relative;
						top: -120px;
					}
					table#isfw-prod-listing-table{
						margin-top: 20px;
						width: 100%;
						position: relative;
						top: -120px;
					}
					table#isfw-prod-listing-table tr th {
						text-align: left;
						padding: 5px;
					}
					#isfw-prod-listing-table-title {
						background-color: gray;
						color: white;
					}
					#isfw-invoice-title-to{
						position: relative;
						top: -120px;
					}
					#isfw-prod-listing-table-bottom{
						border-bottom: 2px solid black;
						position: relative;
						top: -100px;
					}
					#isfw-prod-total-calc{
						margin-left: 540px;
						position: relative;
						top: -90px;
					}
					#isfw-table-items{
						width: 400px !important;
					}
					#isfw-pdf-prod-body tr{
						padding-bottom: 50px !important;
					}
					#isfw-invoice-text{
						color: gray;
					}
				</style>
				</head>
				<body>
					<div id="isfw-pdf">
						<div id="isfw-pdf-header">
							<div id="isfw-invoice-title-left">
								<h2 id="isfw-invoice-text">
									INVOICE
								</h2>
								<div>
									<b>Invoice Number</b><br/>
									123456
								</div>
								<div>
									<b>Date</b><br/>
									' . date( 'd/m/y' ) . '
								</div>
							</div>
							<div id="isfw-invoice-title-right">
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
						</div>
						<div id="isfw-invoice-title-to" >
							<h3>Invoice name</h3>
							<div>
								John<br/>
								<b>Address</b><br/>
								Lucknow ,<br/> India
								9163758888
								abc@xyz.com
							</div>
						</div>
						<div>
							<table id="isfw-prod-listing-table">
								<thead>
									<tr id="isfw-prod-listing-table-title">
										<th id="isfw-table-items">Items</th>
										<th>Quantity</th>
										<th>Price</th>
										<th>Tax</th>
										<th>Amount</th>
									</tr>
								</thead>
								<tbody id="isfw-pdf-prod-body">
									<tr>
										<td>Flying Ninja</td>
										<td>1</td>
										<td>105.00</td>
										<td>10%</td>
										<td>135.00</td>
									</tr>
									<tr>
										<td>Flying Ninja</td>
										<td>1</td>
										<td>100.00</td>
										<td>10%</td>
										<td>110.00</td>
									</tr>
									<tr>
										<td>Flying Ninja</td>
										<td>1</td>
										<td>100.00</td>
										<td>10%</td>
										<td>110.00</td>
									</tr>
									<tr>
										<td>Flying Ninja lorem iposum dolor amet Flying Ninja lorem iposum dolor amet</td>
										<td>1</td>
										<td>100.00</td>
										<td>10%</td>
										<td>110.00</td>
									</tr>
								</tbody>
							</table>
							<div id="isfw-prod-listing-table-bottom"></div>
							<div id="isfw-prod-total-calc">
								<table>
									<tr>
										<td>Subtotal : </td>
										<td>440.00</td>
									</tr>
									<tr>
										<td>Shipping : </td>
										<td>100.00</td>
									</tr>
									<tr>
										<td>Total : </td>
										<td>540.00</td>
									</tr>
								</table>
							</div>
							<div>
								Thank you for shopping with us. Hope to see you again.
							</div>
						</div>
					</div>
				</body>
				</html>';
$dompdf->loadHtml( $html );
$dompdf->setPaper( 'A4', 'portrait' );
ob_end_clean();
$dompdf->render();
$dompdf->stream( 'document.pdf', array( 'Attachment' => 0 ) );

