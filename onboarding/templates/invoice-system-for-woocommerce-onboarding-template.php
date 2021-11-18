<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Invoice_system_for_woocommere
 * @subpackage Invoice_system_for_woocommere/admin/onboarding
 */

global $isfw_mwb_isfw_obj;
$isfw_onboarding_form_fields = apply_filters( 'mwb_isfw_on_boarding_form_fields', array() );
?>

<?php if ( ! empty( $isfw_onboarding_form_fields ) ) : ?>
	<div class="mdc-dialog mdc-dialog--scrollable">
		<div class="mwb-isfw-on-boarding-wrapper-background mdc-dialog__container">
			<div class="mwb-isfw-on-boarding-wrapper mdc-dialog__surface" role="alertdialog" aria-modal="true" aria-labelledby="my-dialog-title" aria-describedby="my-dialog-content">
				<div class="mdc-dialog__content">
					<div class="mwb-isfw-on-boarding-close-btn">
						<a href="#"><span class="isfw-close-form material-icons mwb-isfw-close-icon mdc-dialog__button" data-mdc-dialog-action="close">clear</span></a>
					</div>

					<h3 class="mwb-isfw-on-boarding-heading mdc-dialog__title"><?php esc_html_e( 'Welcome to MakeWebBetter', 'invoice-system-for-woocommerce' ); ?> </h3>
					<p class="mwb-isfw-on-boarding-desc"><?php esc_html_e( 'We love making new friends! Subscribe below and we promise to keep you up-to-date with our latest new plugins, updates, awesome deals and a few special offers.', 'invoice-system-for-woocommerce' ); ?></p>

					<form action="#" method="post" class="mwb-isfw-on-boarding-form">
						<?php
						$isfw_onboarding_html = $isfw_mwb_isfw_obj->mwb_isfw_plug_generate_html( $isfw_onboarding_form_fields );
						echo esc_html( $isfw_onboarding_html );
						?>
						<div class="mwb-isfw-on-boarding-form-btn__wrapper mdc-dialog__actions">
							<div class="mwb-isfw-on-boarding-form-submit mwb-isfw-on-boarding-form-verify ">
								<input type="submit" class="mwb-isfw-on-boarding-submit mwb-on-boarding-verify mdc-button mdc-button--raised" value="Send Us">
							</div>
							<div class="mwb-isfw-on-boarding-form-no_thanks">
								<a href="#" class="mwb-isfw-on-boarding-no_thanks mdc-button" data-mdc-dialog-action="discard"><?php esc_html_e( 'Skip For Now', 'invoice-system-for-woocommerce' ); ?></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="mdc-dialog__scrim"></div>
	</div>
<?php endif; ?>
