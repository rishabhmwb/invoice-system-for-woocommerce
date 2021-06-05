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
		global $wp;
		$url_here                                 = home_url( $wp->request );
		$isfw_allow_invoice_generation_for_orders = get_option( 'isfw_allow_invoice_generation_for_orders' );
		if ( $isfw_allow_invoice_generation_for_orders ) {
			$order_status_show_invoice = preg_replace( '/wc-/', '', $isfw_allow_invoice_generation_for_orders );
			if ( is_object( $order ) ) {
				if ( $order_status_show_invoice === $order->get_status() ) {
					require INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'public/templates/invoice-system-for-woocommerce-public-add-column.php';
				}
			}
		}
	}
	/**
	 * Generate pdf for user from the orders listing page.
	 *
	 * @return void
	 */
	public function isfw_generate_pdf_for_user() {
		require_once INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'common/class-invoice-system-for-woocommerce-common.php';
		$common_class                             = new Invoice_System_For_Woocommerce_Common( $this->plugin_name, $this->version );
		$isfw_allow_invoice_generation_for_orders = get_option( 'isfw_allow_invoice_generation_for_orders' );
		if ( isset( $_GET['order_id'] ) && isset( $_GET['action'] ) ) { // phpcs:ignore
			$user_id = get_current_user_id();
			if ( 'userpdfdownload' === $_GET['action'] ) { // phpcs:ignore
				$order_id = sanitize_text_field( wp_unslash( $_GET['order_id'] ) ); // phpcs:ignore
				if ( $isfw_allow_invoice_generation_for_orders ) {
					$order_status_show_invoice = preg_replace( '/wc-/', '', $isfw_allow_invoice_generation_for_orders );
					$order                     = wc_get_order( $order_id );
					if ( $order && ( $order->get_status() === $order_status_show_invoice ) ) {
						if ( $order->get_customer_id() == $user_id ) { // phpcs:ignore
							$common_class->isfw_common_generate_pdf( $order_id, 'invoice', 'download_locally' );
						}
					}
				}
			}
		}
	}
	/**
	 * Adding link to generate pdf at thank you page woocommerce for guest user.
	 *
	 * @param string $thanks_msg thank you message.
	 * @param object $order order object.
	 * @return string
	 */
	public function isfw_pdf_generation_link_for_guest_user( $thanks_msg, $order ) {
		global $wp;
		$url_here                                 = home_url( $wp->request );
		$download_url                             = add_query_arg(
			array(
				'order_id' => $order->get_id(),
				'action'   => 'userpdfdownload',
			),
			$url_here
		);
		$isfw_allow_invoice_generation_for_orders = get_option( 'isfw_allow_invoice_generation_for_orders' );
		if ( $isfw_allow_invoice_generation_for_orders ) {
			$order_status_show_invoice = preg_replace( '/wc-/', '', $isfw_allow_invoice_generation_for_orders );
			if ( $order_status_show_invoice === $order->get_status() ) {
				require_once INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'public/templates/invice-system-for-woocommerce-public-add-invoice-download-link.php';
				$download_button = return_invoice_download_button( $download_url );
				return $thanks_msg . $download_button;
			}
		}
		return $thanks_msg;
	}
	/**
	 * Adding button to download invoice at the order details page for my account users.
	 *
	 * @param object $order order object.
	 * @return void
	 */
	public function isfw_show_download_invoice_button_on_order_description_page( $order ) {
		global $wp;
		$url_here                                 = home_url( $wp->request );
		$download_url                             = add_query_arg(
			array(
				'order_id' => $order->get_id(),
				'action'   => 'userpdfdownload',
			),
			$url_here
		);
		$isfw_allow_invoice_generation_for_orders = get_option( 'isfw_allow_invoice_generation_for_orders' );
		if ( $isfw_allow_invoice_generation_for_orders ) {
			$order_status_show_invoice = preg_replace( '/wc-/', '', $isfw_allow_invoice_generation_for_orders );
			if ( is_object( $order ) ) {
				if ( $order_status_show_invoice === $order->get_status() ) {
					require_once INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'public/templates/invice-system-for-woocommerce-public-add-invoice-download-link.php';
					$download_button = return_invoice_download_button( $download_url );
					echo $download_button; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}
		}
	}
}

