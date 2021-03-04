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
$isfw_support_settings = apply_filters( 'isfw_supprot_tab_settings_array', array() );
?>
<!--  template file for admin settings. -->
<div class="isfw-section-wrap">
	<?php if ( is_array( $isfw_support_settings ) && ! empty( $isfw_support_settings ) ) { ?>
		<?php foreach ( $isfw_support_settings as $isfw_support_setting ) { ?>
		<div class="mwb-col-wrap">
			<div class="mwb-shadow-panel">
				<div class="content-wrap">
					<div class="content">
						<h3><?php echo esc_html( $isfw_support_setting['title'] ); ?></h3>
						<p><?php echo esc_html( $isfw_support_setting['description'] ); ?></p>
					</div>
					<div class="mdc-button mdc-button--raised mwb-cta-btn"><span class="mdc-button__ripple"></span>
						<a href="#" class="mwb-btn mwb-btn-primary"><?php echo esc_html( $isfw_support_setting['link-text'] ); ?></a>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	<?php } ?>
</div>
