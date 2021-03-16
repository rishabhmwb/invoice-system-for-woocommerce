<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Invoice_system_for_woocommerce
 * @subpackage Invoice_system_for_woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * namespace invoice_system_for_woocommerce_public.
 *
 * @package    Invoice_system_for_woocommerce
 * @subpackage Invoice_system_for_woocommerce/public
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Invoice_System_For_Woocommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function isfw_public_enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'public/src/scss/invoice-system-for-woocommerce-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function isfw_public_enqueue_scripts() {

		wp_register_script( $this->plugin_name, INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'public/src/js/invoice-system-for-woocommerce-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'isfw_public_param', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->plugin_name );

	}
	/**
	 * Adding page to show on the tab download invoice.
	 *
	 * @param array $items items in the nav manu.
	 *
	 * @return array
	 */
	public function isfw_add_content_to_orders_listing_page( $items ) {
		$items['isfw_invoice_download'] = __( 'Invoice', 'invoice-system-for-woocommerce' );
		return $items;
	}
	/**
	 * Adding link to product download in the custom column at customer dashboard orders.
	 *
	 * @param object $order order object.
	 *
	 * @return void
	 */
	public function isfw_add_data_to_custom_column( $order ) {
		$upload_dir     = wp_upload_dir();
		$upload_baseurl = $upload_dir['baseurl'] . '/invoices/';
		$file_pdf_url   = $upload_baseurl . 'invoice_' . $order->get_id() . '.pdf';
		$upload_basedir = $upload_dir['basedir'] . '/invoices/';
		$file_pdf_path  = $upload_basedir . 'invoice_' . $order->get_id() . '.pdf';
		if ( file_exists( $file_pdf_path ) ) {
			echo '<a href="' . esc_attr( $file_pdf_url ) . '" download>' . __( "Download", "invoice-system-for-woocommerce" ) . '</a>'; // phpcs:ignore
		}
	}
}
