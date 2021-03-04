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
require INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_PATH . 'package/lib/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
if ( isset( $_POST['submit_settings_isfw_invoice'] ) ) {
	if ( wp_verify_nonce( $_POST['general_setting_isfw_invoice'], 'submitting_general_setting_isfw' ) ) {
		$prefix = $_POST['mwb_isfw_invoice_number_prefix'];
		$number = $_POST['mwb_isfw_invoice_number'];
		$suffix = $_POST['mwb_isfw_invoice_number_suffix'];
		$disclaimer = $_POST['mwb_isfw_invoice_disclaimer'];
		$color = $_POST['mwb_isfw_invoice_color'];
		$data = array( $prefix, $number, $suffix, $disclaimer, $color );
		echo '<pre>';
		print_r( $data );
	} else {
		echo '<script>alert("oops");</script>';
	}
}
if ( isset( $_POST['create_pdf'] ) ) {
	if ( wp_verify_nonce( $_POST['general_setting_isfw_invoice'], 'submitting_general_setting_isfw' ) ) {
		$prefix = $_POST['mwb_isfw_invoice_number_prefix'];
		$number = $_POST['mwb_isfw_invoice_number'];
		$suffix = $_POST['mwb_isfw_invoice_number_suffix'];
		$disclaimer = $_POST['mwb_isfw_invoice_disclaimer'];
		$color = $_POST['mwb_isfw_invoice_color'];
		create_pdf( $color );
	}
}
function create_pdf( $color ) {
	$dompdf = new Dompdf();
	$html   = '<!DOCTYPE html>
			<html lang="en">
				<head>
				<link rel="preconnect" href="https://fonts.gstatic.com">
				<link href="https://fonts.googleapis.com/css2?family=Akaya+Telivigala&display=swap" rel="stylesheet">
					<style>
							#company-details-mwbpdf-builder{
									cursor: pointer;
							}
							.pdf-color-template{
									color: ' . $color . ';
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
							@font-face {
								font-family: "Akaya Telivigala", cursive;
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
							<td>
								[Name]
							</td>
							</tr>
							<tr>
							<td>
								[Company name]
							</td>
							</tr>
							<tr>
							<td>
								[Street address]
							</td>
							</tr>
							<tr>
							<td>
								[City, st, zip]
							</td>
							</tr>
							<tr>
							<td>
								[Phone]
							</td>
							</tr>
							<tr>
							<td>
								[Email address]
							</td>
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
$dompdf->loadHtml( $html );
$dompdf->setPaper( 'A4' );
ob_end_clean();
$dompdf->render();
$dompdf->stream( 'document.pdf', array( 'Attachment' => 0 ) );

}
?>
<!--  template file for admin settings. -->
<form action="" method="POST" class="mwb-isfw-gen-section-form">
<?php wp_nonce_field( 'submitting_general_setting_isfw', 'general_setting_isfw_invoice' ); ?>
	<div class="isfw-secion-wrap">
		<div>
			<label for="mwb_isfw_invoice_number">
				<b><?php esc_html_e( 'Invoice Number', 'invoice-system-for-woocommere' ); ?></b>
				<input type="text" name="mwb_isfw_invoice_number_prefix" id="mwb_isfw_invoice_number_prefix" placeholder="Prefix">
				<input type="number" name="mwb_isfw_invoice_number" id="mwb_isfw_invoice_number" placeholder="No. of Digits">
				<input type="text" name="mwb_isfw_invoice_number_suffix" id="mwb_isfw_invoice_number_suffix" placeholder="Suffix">
			</label>
		</div>
		<div>
			<label for="mwb_isfw_invoice_renew_date">
			<?php esc_html_e( 'Invoice Renew', 'invoice-system-for-woocommere' ); ?>
				<select name="mwb_isfw_invoice_renew_month" id="mwb_isfw_invoice_renew_month">
					<option value="norenew"><?php esc_html_e( 'No Renew', 'invoice-system-for-woocommere' ); ?></option>
					<option value=""></option>
				</select>
				<select name="mwb_isfw_invoice_renew_date" id="mwb_isfw_invoice_renew_date">
					<option value="norenew"><?php esc_html_e( 'Month', 'invoice-system-for-woocommere' ); ?></option>
					<option value=""></option>
				</select>
			</label>
		</div>
		<div>
			<label for="mwb_isfw_invoice_layout">
			<?php esc_html_e( 'Select Layout', 'invoice-system-for-woocommere' ); ?>
					<img src="" alt="image1">
					<img src="" alt="image2">
			</label>
		</div>
		<div>
			<label for="mwb_isfw_invoice_logo_image">
			<?php esc_html_e( 'Logo for Invoice', 'invoice-system-for-woocommere' ); ?>
				<input type="file" name="mwb_isfw_invoice_image" id="mwb_isfw_invoice_image">
			</label>
		</div>
		<div>
			<label for="mwb_isfw_invoice_disclaimer">
				<?php esc_html_e( 'Disclaimer', 'invoice-system-for-woocommere' ); ?>
				<textarea name="mwb_isfw_invoice_disclaimer" id="mwb_isfw_invoice_disclaimer" cols="30" rows="10"></textarea>
			</label>
		</div>
		<div>
			<label for="mwb_isfw_invoice_color">
			<?php esc_html_e( 'Color', 'mwb_isfw_invoice_color' ); ?>
				<input type="color" name="mwb_isfw_invoice_color" id="mwb_isfw_invoice_color" value = '#000000'>
			</label>
		</div>
		<div>
			<input type="submit" value="submit" name="submit_settings_isfw_invoice">
			<input type="submit" value="create_pdf" name ="create_pdf">
		</div>
	</div>
</form>
