<?php
/**
 * Provide a admin area page overview.
 *
 * This file is used to markup the html field for overview tab.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Invoice_system_for_woocommere
 * @subpackage Invoice_system_for_woocommere/admin/partials
 */

?>
<div class="isfw-overview__wrapper">
	<div class="isfw-overview__banner">
		<img src="<?php echo esc_html( INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/isfw-banner.png' ); ?>" alt="Overview banner image">
	</div>
	<div class="isfw-overview__content">
		<div class="isfw-overview__content-description">
			<h2><?php echo esc_html_e( 'What Is Invoice System For WooCommerce?', 'invoice-system-for-woocommerce' ); ?></h2>
			<p>
				<?php
				esc_html_e(
					'Invoice System for WooCommerce plugin automatically generates WooCommerce PDF invoices and attaches them to the relative WooCommerce emails. This plugin is the most-apt solution to eliminate the extra effort put in manually generating the invoices. This plugin extends your store’s functionalities by enabling you to generate bulk invoices with 2 pre-built customizable invoice templates.                 '
				);
				?>
			</p>
			<h3><?php esc_html_e( 'As a store owner, you get to:', 'invoice-system-for-woocommerce' ); ?></h3>
			<div class="isfw-overview__features-wrapper">
				<ul class="isfw-overview__features">
					<li><?php esc_html_e( 'Saves time and labor cost involved in manual invoice curation.', 'invoice-system-for-woocommerce' ); ?></li>
					<li><?php esc_html_e( 'Easy and paper-less sharing of invoices via WooCommerce emails as PDF attachments.', 'invoice-system-for-woocommerce' ); ?></li>
					<li><?php esc_html_e( 'Convenient options for both merchants and customers to download invoices', 'invoice-system-for-woocommerce' ); ?></li>
					<li><?php esc_html_e( 'Prefix/suffix feature for creating customized invoice numbers increase brand value', 'invoice-system-for-woocommerce' ); ?></li>
					<li><?php esc_html_e( 'Improves brand image and awareness among your customers with customizable invoice templates.', 'invoice-system-for-woocommerce' ); ?></li>
				</ul>
				<!-- <div class="isfw-overview__video--url">
					<iframe width="560" height="315" src="https://www.youtube.com/embed/fTET_cOY9qg" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div> -->

			</div>
		</div>
		<h2> <?php esc_html_e( 'The Free Plugin Benefits', 'invoice-system-for-woocommerce' ); ?></h2>
		<div class="isfw-overview__keywords">
			<div class="isfw-overview__keywords-item">
				<div class="isfw-overview__keywords-card">
					<div class="isfw-overview__keywords-image">
						<img src="<?php echo esc_html( INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/invoice_prebuilt_template_icon.png' ); ?>" alt="Advanced-report image">
					</div>
					<div class="isfw-overview__keywords-text">
						<h3 class="isfw-overview__keywords-heading"><?php echo esc_html_e( 'Pre-built Invoice Templates', 'invoice-system-for-woocommerce' ); ?></h3>
						<p class="isfw-overview__keywords-description">
							<?php
							esc_html_e(
								'The Invoice System for WooCommerce plugin provides 2 fully customizable invoice templates to enhance brand value for the products.',
								'invoice-system-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="isfw-overview__keywords-item">
				<div class="isfw-overview__keywords-card">
					<div class="isfw-overview__keywords-image">
						<img src="<?php echo esc_html( INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/invoice_share_via_email_icon.png' ); ?>" alt="Workflow image">
					</div>
					<div class="isfw-overview__keywords-text">
						<h3 class="isfw-overview__keywords-heading"><?php echo esc_html_e( 'Share Invoices via Email', 'invoice-system-for-woocommerce' ); ?></h3>
						<p class="isfw-overview__keywords-description"><?php echo esc_html_e( 'This invoice plugin allows you to share individual or bulk invoices and packing slips with the concerned customers via WooCommerce email.', 'invoice-system-for-woocommerce' ); ?></p>
					</div>
				</div>
			</div>
			<div class="isfw-overview__keywords-item">
				<div class="isfw-overview__keywords-card">
					<div class="isfw-overview__keywords-image">
						<img src="<?php echo esc_html( INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/invoice_customizable_icon.png' ); ?>" alt="Variable product image">
					</div>
					<div class="isfw-overview__keywords-text">
						<h3 class="isfw-overview__keywords-heading"><?php echo esc_html_e( 'Customizable Invoice Number', 'invoice-system-for-woocommerce' ); ?></h3>
						<p class="isfw-overview__keywords-description">
							<?php
							echo esc_html_e(
								'Admin can add/remove prefix and suffix to the invoice number to provide more personalized perception to customers.',
								'invoice-system-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="isfw-overview__keywords-item">
				<div class="isfw-overview__keywords-card">
					<div class="isfw-overview__keywords-image">
						<img src="<?php echo esc_html( INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/invoice_easy_downloading_icon.png' ); ?>" alt="List-of-abandoned-users image">
					</div>
					<div class="isfw-overview__keywords-text">
						<h3 class="isfw-overview__keywords-heading"><?php echo esc_html_e( 'Easy Downloading of PDF Invoices', 'invoice-system-for-woocommerce' ); ?></h3>
						<p class="isfw-overview__keywords-description">
							<?php
							echo esc_html_e(
								'This Invoice System for WooCommerce plugin gives admin and customers an equal right to download the invoices in PDF format from the Order Admin page and My Account page.',
								'invoice-system-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="isfw-overview__keywords-item">
				<a href="https://makewebbetter.com/contact-us/" title="">
					<div class="isfw-overview__keywords-card mwb-card-support">
						<div class="isfw-overview__keywords-image">
							<img src="<?php echo esc_html( INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/invoice_renew_number_sequence_icon.png' ); ?>" alt="Support image">
						</div>
						<div class="isfw-overview__keywords-text">
							<h3 class="isfw-overview__keywords-heading"><?php echo esc_html_e( 'Renew Invoice Number Sequence', 'invoice-system-for-woocommerce' ); ?></h3>
							<p class="isfw-overview__keywords-description">
								<?php
								esc_html_e(
									'Invoice System for WooCommerce plugin also allows the admin to renew the invoice number sequence with every new financial year.',
									'invoice-system-for-woocommerce'
								);
								?>
							</p>
						</div>
					</a>
				</div>
			</div>
			<div class="isfw-overview__keywords-item">
				<a href="https://makewebbetter.com/contact-us/" title="">
					<div class="isfw-overview__keywords-card mwb-card-support">
						<div class="isfw-overview__keywords-image">
							<img src="<?php echo esc_html( INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/invoice_bulk_icon.png' ); ?>" alt="Support image">
						</div>
						<div class="isfw-overview__keywords-text">
							<h3 class="isfw-overview__keywords-heading"><?php echo esc_html_e( 'Bulk Invoices & Packaging Slips', 'invoice-system-for-woocommerce' ); ?></h3>
							<p class="isfw-overview__keywords-description">
								<?php
								esc_html_e(
									'Invoice System for WooCommerce plugin allows the admin to generate PDF invoices and packaging slips in bulk.',
									'invoice-system-for-woocommerce'
								);
								?>
							</p>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
