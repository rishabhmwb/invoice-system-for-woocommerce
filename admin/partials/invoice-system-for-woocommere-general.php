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
	require_once INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_PATH . 'admin/partials/templates/invoice-system-for-woocommerce-pdflayout1.php';
	// require_once INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_PATH . 'admin/partials/templates/invoice-system-for-woocommerce-pdflayout2.php';
	$html   = (string) return_ob_value( 90 );
	$dompdf = new Dompdf();
	$dompdf->loadHtml( $html );
	$dompdf->setPaper( 'A4' );
	ob_end_clean();
	$dompdf->render();
	$dompdf->stream( 'document.pdf', array( 'Attachment' => 0 ) );
}
global $isfw_mwb_isfw_obj;
$isfw_template_pdf_settings = apply_filters( 'isfw_template_pdf_settings_array', array() );
?>
<!--  template file for admin settings. -->
<div class="isfw-section-wrap">
	<?php
		$isfw_template_html = $isfw_mwb_isfw_obj->mwb_isfw_plug_generate_html( $isfw_template_pdf_settings );
		echo esc_html( $isfw_template_html );
	?>
</div>
