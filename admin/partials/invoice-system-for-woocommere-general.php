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
/**
 * Creating pdf.
 *
 * @param color $color color.
 * @return void
 */
function create_pdf( $color ) {
	// require_once INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_PATH . 'admin/partials/templates/invoice-system-for-woocommerce-pdflayout1.php';
	require_once INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_PATH . 'admin/partials/templates/invoice-system-for-woocommerce-pdflayout2.php';
	$html   = (string) return_ob_value();
	$dompdf = new Dompdf();
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
