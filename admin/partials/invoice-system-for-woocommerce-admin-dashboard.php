<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Invoice_system_for_woocommerce
 * @subpackage Invoice_system_for_woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $isfw_mwb_isfw_obj,$isfw_save_check_flag, $wpiwps_save_check_flag;
$isfw_active_tab   = isset( $_GET['isfw_tab'] ) ? sanitize_key( $_GET['isfw_tab'] ) : 'invoice-system-for-woocommerce-general'; // phpcs:ignore
do_action( 'mwb_isfw_license_notification' );
$isfw_default_tabs = $isfw_mwb_isfw_obj->mwb_isfw_plug_default_tabs();
?>
<header>
	<div class="mwb-header-container mwb-bg-white mwb-r-8">
		<h1 class="mwb-header-title"><?php echo esc_attr( strtoupper( str_replace( '-', ' ', apply_filters( 'isfw_plugin_name_show_dashboard', $isfw_mwb_isfw_obj->isfw_get_plugin_name() ) ) ) ); ?></h1>
		<a href="<?php echo esc_attr( apply_filters( 'isfw_plugin_doc_link_dashboard', ' https://docs.makewebbetter.com/invoice-system-for-woocommerce/?utm_source=MWB-invoice-backend&utm_medium=MWB-ORG-Page&utm_campaign=MWB-doc' ) ); ?>" target="_blank" class="mwb-link"><?php esc_html_e( 'Documentation', 'invoice-system-for-woocommerce' ); ?></a>
		<span>|</span>
		<a href="https://makewebbetter.com/contact-us/" target="_blank" class="mwb-link"><?php esc_html_e( 'Support', 'invoice-system-for-woocommerce' ); ?></a>
	</div>
</header>
<?php
if ( $isfw_save_check_flag || $wpiwps_save_check_flag ) {
	$mwb_isfw_error_text = esc_html__( 'Settings saved Successfully!', 'invoice-system-for-woocommerce' );
	$isfw_mwb_isfw_obj->mwb_isfw_plug_admin_notice( $mwb_isfw_error_text, 'success' );
}
?>
<main class="mwb-main mwb-bg-white mwb-r-8">
	<nav class="mwb-navbar">
		<ul class="mwb-navbar__items">
			<?php
			if ( is_array( $isfw_default_tabs ) && ! empty( $isfw_default_tabs ) ) {

				foreach ( $isfw_default_tabs as $isfw_tab_key => $isfw_default_tabs ) {

					$isfw_tab_classes = 'mwb-link ';

					if ( ! empty( $isfw_active_tab ) && $isfw_active_tab === $isfw_tab_key ) {
						$isfw_tab_classes .= 'active';
					}
					?>
					<li>
						<a id="<?php echo esc_attr( $isfw_tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=invoice_system_for_woocommerce_menu' ) . '&isfw_tab=' . esc_attr( $isfw_tab_key ) ); ?>" class="<?php echo esc_attr( $isfw_tab_classes ); ?>"><?php echo esc_html( $isfw_default_tabs['title'] ); ?></a>
					</li>
					<?php
				}
			}
			?>
		</ul>
	</nav>

	<section class="mwb-section">
		<div>
			<?php
			do_action( 'mwb_isfw_before_general_settings_form' );
			// if submenu is directly clicked on woocommerce.
			if ( empty( $isfw_active_tab ) ) {
				$isfw_active_tab = 'mwb_isfw_plug_general';
			}
			// look for the path based on the tab id in the admin templates.
			$isfw_tab_content_path = 'admin/partials/' . $isfw_active_tab . '.php';

			$isfw_mwb_isfw_obj->mwb_isfw_plug_load_template( $isfw_tab_content_path );

			do_action( 'mwb_isfw_after_general_settings_form' );
			?>
		</div>
	</section>
