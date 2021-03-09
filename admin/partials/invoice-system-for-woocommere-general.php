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
