<?php
/**
 * The common-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Invoice_system_for_woocommerce
 * @subpackage Invoice_system_for_woocommerce/common
 */
use Dompdf\Dompdf;
/**
 * The common-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the common-facing stylesheet and JavaScript.
 * namespace invoice_system_for_woocommerce_public.
 *
 * @package    Invoice_system_for_woocommerce
 * @subpackage Invoice_system_for_woocommerce/common
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Invoice_System_For_Woocommerce_Common {

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
	 * Common method for generating pdf.
	 *
	 * @param int    $order_id order id to print invoice for.
	 * @param string $type type invoice or packing slip.
	 * @param string $action either download locally or on server.
	 * @return void
	 */
	public function isfw_common_generate_pdf( $order_id, $type, $action ) {
		require_once INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'package/lib/dompdf/vendor/autoload.php';
		$isfw_pdf_settings = get_option( 'mwb_isfw_pdf_general_settings' );
		if ( $isfw_pdf_settings ) {
			$template = ( array_key_exists( 'template', $isfw_pdf_settings ) ) ? $isfw_pdf_settings['template'] : '';
		} else {
			$template = 'one';
		}
		if ( 'one' === $template ) {
			require_once INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/templates/invoice-system-for-woocommerce-pdflayout1.php';
		} else {
			require_once INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/templates/invoice-system-for-woocommerce-pdflayout2.php';
		}
		$html   = (string) return_ob_value( $order_id, $type );
		$dompdf = new Dompdf( array( 'enable_remote' => true ) );
		$dompdf->loadHtml( $html );
		$dompdf->setPaper( 'A4' );
		@ob_end_clean(); // phpcs:ignore
		$dompdf->render();
		if ( 'download_locally' === $action ) {
			$output         = $dompdf->output();
			$upload_dir     = wp_upload_dir();
			$upload_basedir = $upload_dir['basedir'] . '/invoices/';
			if ( ! file_exists( $upload_basedir ) ) {
				wp_mkdir_p( $upload_basedir );
			}
			$path = $upload_basedir . $type . '_' . $order_id . '.pdf';
			if ( ! file_exists( $path ) ) {
				@file_put_contents( $path, $output ); // phpcs:ignore
			}
			$dompdf->stream( $type . '_' . $order_id . '.pdf', array( 'Attachment' => 1 ) );
		}
		if ( 'download_on_server' === $action ) {
			$output         = $dompdf->output();
			$upload_dir     = wp_upload_dir();
			$upload_basedir = $upload_dir['basedir'] . '/invoices/';
			if ( ! file_exists( $upload_basedir ) ) {
				wp_mkdir_p( $upload_basedir );
			}
			$path = $upload_basedir . $type . '_' . $order_id . '.pdf';
			if ( ! file_exists( $path ) ) {
				@file_put_contents( $path, $output ); // phpcs:ignore
			}
		}
	}
	/**
	 * Adding shortcodes for fetching order details.
	 *
	 * @return void
	 */
	public function isfw_fetch_order_details_shortcode() {
		add_shortcode( 'isfw_fetch_order', array( $this, 'isfw_fetch_order_details' ) );
	}
	/**
	 * Fetching all order details and storing in array.
	 *
	 * @param array $atts attributes which are passed while using shortcode.
	 * @return array
	 */
	public function isfw_fetch_order_details( $atts = array() ) {
		$atts  = shortcode_atts(
			array(
				'order_id' => '',
			),
			$atts
		);
		$order = wc_get_order( $atts['order_id'] );
		if ( $order ) {
			$billing_email         = $order->get_billing_email();
			$billing_phone         = $order->get_billing_phone();
			$customer_id           = $order->get_customer_id();
			$billing_first_name    = $order->get_billing_first_name();
			$billing_last_name     = $order->get_billing_last_name();
			$billing_company       = $order->get_billing_company();
			$billing_address_1     = $order->get_billing_address_1();
			$billing_address_2     = $order->get_billing_address_2();
			$billing_city          = $order->get_billing_city();
			$billing_state         = $order->get_billing_state();
			$billing_postcode      = $order->get_billing_postcode();
			$billing_country       = $order->get_billing_country();
			$payment_method        = $order->get_payment_method();
			$order_status          = $order->get_status();
			$order_subtotal        = preg_replace( '/[^0-9,.]/', '', $order->get_subtotal() );
			$decimal_separator     = wc_get_price_decimal_separator();
			$thousand_separator    = wc_get_price_thousand_separator();
			$decimals              = wc_get_price_decimals();
			$order_product_details = array();
			foreach ( $order->get_items() as  $item_key => $item_values ) {
				$_tax                    = new WC_Tax();
				$item_data               = $item_values->get_data();
				$product_tax             = $_tax->get_rates( $item_data['tax_class'] );
				$product_tax             = is_array( $product_tax ) ? array_shift( $product_tax ) : $product_tax;
				$product_tax             = is_array( $product_tax ) ? array_shift( $product_tax ) : $product_tax;
				$product_tax             = ( $product_tax ) ? $product_tax : 0;
				$order_product_details[] = array(
					'product_id'       => get_post_meta( $item_data['product_id'], '_sku', true ),
					'id'               => $item_data['product_id'],
					'product_name'     => $item_data['name'],
					'product_quantity' => $item_data['quantity'],
					'product_price'    => number_format( ( preg_replace( '/,/', '.', $item_data['total'] ) / $item_data['quantity'] ), $decimals, $decimal_separator, $thousand_separator ),
					'product_tax'      => number_format( preg_replace( '/,/', '.', $item_data['total_tax'] ), $decimals, $decimal_separator, $thousand_separator ),
					'product_total'    => number_format( ( preg_replace( '/,/', '.', $item_data['total'] ) + preg_replace( '/,/', '.', $item_data['total_tax'] ) ), $decimals, $decimal_separator, $thousand_separator ),
					'tax_percent'      => number_format( $product_tax, $decimals, $decimal_separator, $thousand_separator ),
				);
			}
			$shipping_first_name     = $order->get_shipping_first_name();
			$shipping_last_name      = $order->get_shipping_last_name();
			$shipping_company        = $order->get_shipping_company();
			$shipping_address_1      = $order->get_shipping_address_1();
			$shipping_address_2      = $order->get_shipping_address_2();
			$shipping_city           = $order->get_shipping_city();
			$shipping_state          = $order->get_shipping_state();
			$shipping_postcode       = $order->get_shipping_postcode();
			$shipping_country        = $order->get_shipping_country();
			$shipping_method         = $order->get_shipping_method();
			$shipping_total          = preg_replace( '/[^0-9,.]/', '', $order->get_shipping_total() );
			$shipping_total_format   = ( $shipping_total ) ? number_format( $shipping_total, $decimals, $decimal_separator, $thousand_separator ) : 0;
			$shipping_tax            = preg_replace( '/[^0-9,.]/', '', $order->get_shipping_tax() );
			$shipping_total_with_tax = ( $shipping_total ) ? number_format( ( $shipping_total + $shipping_tax ), $decimals, $decimal_separator, $thousand_separator ) : number_format( $shipping_tax, $decimals, $decimal_separator, $thousand_separator );
			$shipping_details        = array(
				'shipping_first_name'     => $shipping_first_name,
				'shipping_last_name'      => $shipping_last_name,
				'shipping_address_1'      => $shipping_address_1,
				'shipping_address_2'      => $shipping_address_2,
				'shipping_city'           => $shipping_city,
				'shipping_company'        => $shipping_company,
				'shipping_state'          => $shipping_state,
				'shipping_postcode'       => $shipping_postcode,
				'shipping_country'        => $shipping_country,
				'shipping_method'         => $shipping_method,
				'shipping_total'          => $shipping_total_format,
				'shipping_tax'            => $shipping_tax,
				'shipping_total_with_tax' => $shipping_total_with_tax,
				'order_status'            => $order_status,
			);
			$cart_total              = preg_replace( '/[^0-9,.]/', '', $order->get_total() );
			$tax_total               = preg_replace( '/[^0-9,.]/', '', $order->get_total_tax() );
			$billing_details         = array(
				'customer_id'        => $customer_id,
				'billing_email'      => $billing_email,
				'billing_phone'      => $billing_phone,
				'billing_first_name' => $billing_first_name,
				'billing_last_name'  => $billing_last_name,
				'billing_company'    => $billing_company,
				'billing_address_1'  => $billing_address_1,
				'billing_address_2'  => $billing_address_2,
				'billing_city'       => $billing_city,
				'billing_state'      => $billing_state,
				'billing_postcode'   => $billing_postcode,
				'billing_country'    => $billing_country,
				'payment_method'     => $payment_method,
				'order_subtotal'     => number_format( $order_subtotal, $decimals, $decimal_separator, $thousand_separator ),
				'order_currency'     => get_woocommerce_currency_symbol(),
				'cart_total'         => number_format( $cart_total, $decimals, $decimal_separator, $thousand_separator ),
				'tax_totals'         => ( $tax_total ) ? number_format( $tax_total, $decimals, $decimal_separator, $thousand_separator ) : 0,
				'order_created_date' => $order->get_date_created()->format( 'd-m-y' ),
			);
			$order_details_arr       = array(
				'shipping_details' => $shipping_details,
				'billing_details'  => $billing_details,
				'product_details'  => $order_product_details,
			);
			return wp_json_encode( $order_details_arr );
		}
		return false;
	}
}
