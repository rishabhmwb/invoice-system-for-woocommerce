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
global $isfw_mwb_isfw_obj,$isfw_save_check_flag;
$isfw_template_pdf_settings = apply_filters( 'isfw_template_pdf_settings_array', array() );
?>
<!--  template file for admin settings. -->
<div class="isfw-section-wrap">
	<form action="" method="post">
		<?php
		wp_nonce_field( 'nonce_settings_save', 'isfw_nonce_field' );
		$isfw_mwb_isfw_obj->mwb_isfw_plug_generate_html( $isfw_template_pdf_settings );
		?>
	</form>
</div>
