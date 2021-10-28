<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html for system status.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Invoice_system_for_woocommerce
 * @subpackage Invoice_system_for_woocommerce/admin/templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return bulk download button with link in it.
 *
 * @param string $file_url url of the file to download.
 * @return string
 */

?>
<div id="isfw_download_zip_pdf_hidden_button">
	<a href="<?php echo esc_attr( $file_url ); ?>" id="isfw_download_zip_pdf"></a>
</div>

