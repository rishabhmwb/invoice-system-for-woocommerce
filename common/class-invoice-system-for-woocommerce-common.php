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
	 * Schedular for resetting invoice number.
	 *
	 * @since 1.0.1
	 * @return void
	 */
	public function isfw_reset_invoice_number_schedular() {
		if ( ! as_next_scheduled_action( 'isfw_reset_invoice_number_hook' ) ) {
			as_schedule_recurring_action( strtotime( 'tomorrow' ), DAY_IN_SECONDS, 'isfw_reset_invoice_number_hook' );
		}
	}
	/**
	 * Reset invoice number.
	 *
	 * @since 1.0.1
	 * @return void
	 */
	public function isfw_reset_invoice_number() {
		$month = get_option( 'isfw_invoice_number_renew_month' );
		$date  = get_option( 'isfw_invoice_number_renew_date' );
		if ( '' !== $month && 'never' !== $month ) {
			if ( ( (int) current_time( 'm' ) === (int) $month ) && ( (int) current_time( 'd' ) === (int) $date ) ) {
				update_option( 'isfw_current_invoice_id', 0 );
			}
		}
	}
	/**
	 * Generate Invoice Number.
	 *
	 * @param int $order_id order ID to generate invoice number for.
	 * @since 1.0.0
	 * @return string
	 */
	public function isfw_invoice_number( $order_id ) {
		$digit  = get_option( 'isfw_invoice_number_digit' );
		$prefix = get_option( 'isfw_invoice_number_prefix' );
		$suffix = get_option( 'isfw_invoice_number_suffix' );
		$digit  = ( $digit ) ? $digit : 4;
		$in_id  = get_post_meta( $order_id, 'isfw_order_invoice_id', true );
		if ( $in_id ) {
			$invoice_id = $in_id;
		} else {
			$prev_invoice_id = get_option( 'isfw_current_invoice_id' );
			if ( $prev_invoice_id ) {
				$curr_invoice_id = $prev_invoice_id + 1;
			} else {
				$curr_invoice_id = 1;
			}
			update_option( 'isfw_current_invoice_id', $curr_invoice_id );
			$invoice_number = str_pad( $curr_invoice_id, $digit, '0', STR_PAD_LEFT );
			$invoice_id     = $prefix . $invoice_number . $suffix;
			update_post_meta( $order_id, 'isfw_order_invoice_id', $invoice_id );
		}
		return $invoice_id;
	}
	/**
	 * Invoice name for the file to be stored or downloaded.
	 *
	 * @param string $type invoice or packing slip.
	 * @param int    $order_id order id to generate invoice for.
	 * @return string
	 */
	public function isfw_invoice_name_for_file( $type, $order_id ) {
		$invoice_name_option = get_option( 'mwb_wpiwps_invoice_name' );
		$invoice_id          = $this->isfw_invoice_number( $order_id );
		if ( 'invoice' === $type ) {
			if ( 'custom' === $invoice_name_option ) {
				$custom_invoice_name = get_option( 'mwb_wpiwps_custom_invoice_name' );
				$invoice_name        = $custom_invoice_name . '_' . $order_id;
			} elseif ( 'invoice_orderid' === $invoice_name_option ) {
				$invoice_name = 'invoice_' . $order_id;
			} elseif ( 'invoice_id' === $invoice_name_option ) {
				$invoice_name = $invoice_id;
			} else {
				$invoice_name = $type . '_' . $order_id;
			}
		} else {
			$invoice_name = $type . '_' . $order_id;
		}
		return $invoice_name;
	}

	/**
	 * Download file by passing file url.
	 *
	 * @param string $file_url url of the file to download.
	 * @return void
	 */
	public function isfw_download_already_existing_invoice_file( $file_url ) {
		@ob_end_clean(); // phpcs:ignore
		header( 'Content-Type: application/octet-stream' );
		header( 'Content-Transfer-Encoding: Binary' );
		header( 'Content-disposition: attachment; filename="' . basename( $file_url ) . '"' );
		readfile( $file_url ); // phpcs:ignore WordPress
		exit;
	}
	/**
	 * Common method for generating pdf.
	 *
	 * @param int    $order_id order id to print invoice for.
	 * @param string $type type invoice or packing slip.
	 * @param string $action either download locally or on server.
	 * @return string
	 */
	public function isfw_common_generate_pdf( $order_id, $type, $action ) {
		require_once INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'package/lib/dompdf/vendor/autoload.php';
		$isfw_invoice_template            = get_option( 'isfw_invoice_template' );
		$isfw_generate_invoice_from_cache = get_option( 'isfw_generate_invoice_from_cache' );
		$invoice_id                       = $this->isfw_invoice_number( $order_id );
		$invoice_name                     = $this->isfw_invoice_name_for_file( $type, $order_id );
		$upload_dir                       = wp_upload_dir();
		$upload_basedir                   = $upload_dir['basedir'] . '/invoices/';
		$path                             = $upload_basedir . $invoice_name . '.pdf';
		$file_url                         = $upload_dir['baseurl'] . '/invoices/' . $invoice_name . '.pdf';
		if ( ( 'yes' === $isfw_generate_invoice_from_cache ) && file_exists( $path ) ) {
			if ( 'download_locally' === $action ) {
				$this->isfw_download_already_existing_invoice_file( $file_url );
			} elseif ( 'download_on_server' === $action ) {
				return $path;
			}
		} else {
			if ( $isfw_invoice_template ) {
				$template = $isfw_invoice_template;
			} else {
				$template = 'one';
			}
			if ( 'one' === $template ) {
				$template_path = INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/templates/invoice-system-for-woocommerce-pdflayout1.php';
			} else {
				$template_path = INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/templates/invoice-system-for-woocommerce-pdflayout2.php';
			}
			$template_path = apply_filters( 'isfw_load_template_for_invoice_generation', $template_path );
			require_once $template_path;
			$html   = (string) return_ob_value( $order_id, $type, $invoice_id );
			$dompdf = new Dompdf( array( 'enable_remote' => true ) );
			$dompdf->loadHtml( $html );
			$dompdf->setPaper( 'A4' );
			@ob_end_clean(); // phpcs:ignore
			$dompdf->render();
			if ( ! file_exists( $upload_basedir ) ) {
				wp_mkdir_p( $upload_basedir );
			}
			if ( 'download_locally' === $action ) {
				$output = $dompdf->output();
				if ( file_exists( $path ) ) {
					@unlink( $path ); // phpcs:ignore
				}
				if ( ! file_exists( $path ) ) {
					@file_put_contents( $path, $output ); // phpcs:ignore
				}
				if ( 'invoice' === $type ) {
					do_action( 'mwb_isfw_upload_invoice_in_storage', $path, $file_url, $order_id, $invoice_name );
				}
				$dompdf->stream( $invoice_name . '.pdf', array( 'Attachment' => 1 ) );
			}
			if ( 'open_window' === $action ) {
				$output = $dompdf->output();
				$dompdf->stream( $invoice_name . '.pdf', array( 'Attachment' => 0 ) );
			}
			if ( 'download_on_server' === $action ) {
				$output = $dompdf->output();
				if ( file_exists( $path ) ) {
					@unlink( $path ); // phpcs:ignore
				}
				if ( ! file_exists( $path ) ) {
					@file_put_contents( $path, $output ); // phpcs:ignore
				}
				if ( 'invoice' === $type ) {
					do_action( 'mwb_isfw_upload_invoice_in_storage', $path, $file_url, $order_id, $invoice_name );
				}
				return $path;
			}
		}
	}
	/**
	 * Adding shortcodes for fetching order details.
	 *
	 * @return void
	 */
	public function isfw_fetch_order_details_shortcode() {
		add_shortcode( 'ISFW_FETCH_ORDER', array( $this, 'isfw_fetch_order_details' ) );
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
		if ( is_a( $order, 'WC_Order_Refund' ) ) {
			$order = wc_get_order( $order->get_parent_id() );
		}
		if ( $order ) {
			$order_subtotal     = preg_replace( '/[^0-9,.]/', '', $order->get_subtotal() );
			$decimal_separator  = wc_get_price_decimal_separator();
			$thousand_separator = wc_get_price_thousand_separator();
			$decimals           = wc_get_price_decimals();
			$isfw_coupon_fee    = array();
			$coupon_fees        = $order->get_fees();
			if ( is_array( $coupon_fees ) ) {
				foreach ( $coupon_fees as $item_fee ) {
					$fee_name                     = $item_fee->get_name();
					$fee_total                    = $item_fee->get_total();
					$isfw_coupon_fee[ $fee_name ] = $fee_total;
				}
			}
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
					'item_meta'        => $item_values->get_formatted_meta_data(),
					'product_name'     => $item_data['name'],
					'product_quantity' => $item_data['quantity'],
					'product_price'    => ( 0 !== (int) $item_data['quantity'] ) ? number_format( ( preg_replace( '/,/', '.', $item_data['total'] ) / $item_data['quantity'] ), $decimals, $decimal_separator, $thousand_separator ) : 0,
					'product_tax'      => number_format( preg_replace( '/,/', '.', $item_data['total_tax'] ), $decimals, $decimal_separator, $thousand_separator ),
					'product_total'    => number_format( ( preg_replace( '/,/', '.', $item_data['total'] ) + preg_replace( '/,/', '.', $item_data['total_tax'] ) ), $decimals, $decimal_separator, $thousand_separator ),
					'tax_percent'      => number_format( $product_tax, $decimals, $decimal_separator, $thousand_separator ),
				);
			}
			$shipping_total          = preg_replace( '/[^0-9,.]/', '', $order->get_shipping_total() );
			$shipping_total_format   = ( $shipping_total ) ? number_format( $shipping_total, $decimals, $decimal_separator, $thousand_separator ) : 0;
			$shipping_tax            = preg_replace( '/[^0-9,.]/', '', $order->get_shipping_tax() );
			$shipping_total_with_tax = ( $shipping_total ) ? number_format( ( $shipping_total + $shipping_tax ), $decimals, $decimal_separator, $thousand_separator ) : number_format( $shipping_tax, $decimals, $decimal_separator, $thousand_separator );
			$shipping_details        = array(
				'shipping_first_name'     => $order->get_shipping_first_name(),
				'shipping_last_name'      => $order->get_shipping_last_name(),
				'shipping_address_1'      => $order->get_shipping_address_1(),
				'shipping_address_2'      => $order->get_shipping_address_2(),
				'shipping_city'           => $order->get_shipping_city(),
				'shipping_company'        => $order->get_shipping_company(),
				'shipping_state'          => $order->get_shipping_state(),
				'shipping_postcode'       => $order->get_shipping_postcode(),
				'shipping_country'        => $order->get_shipping_country(),
				'shipping_method'         => $order->get_shipping_method(),
				'shipping_total'          => $shipping_total_format,
				'shipping_tax'            => $shipping_tax,
				'shipping_total_with_tax' => $shipping_total_with_tax,
				'order_status'            => $order->get_status(),
			);
			$cart_total              = preg_replace( '/[^0-9,.]/', '', $order->get_total() );
			$tax_total               = preg_replace( '/[^0-9,.]/', '', $order->get_total_tax() );
			$billing_details         = array(
				'coupon_details'     => $isfw_coupon_fee,
				'customer_id'        => $order->get_customer_id(),
				'billing_email'      => $order->get_billing_email(),
				'billing_phone'      => $order->get_billing_phone(),
				'billing_first_name' => $order->get_billing_first_name(),
				'billing_last_name'  => $order->get_billing_last_name(),
				'billing_company'    => $order->get_billing_company(),
				'billing_address_1'  => $order->get_billing_address_1(),
				'billing_address_2'  => $order->get_billing_address_2(),
				'billing_city'       => $order->get_billing_city(),
				'billing_state'      => $order->get_billing_state(),
				'billing_postcode'   => $order->get_billing_postcode(),
				'billing_country'    => $order->get_billing_country(),
				'payment_method'     => $order->get_payment_method_title(),
				'order_subtotal'     => number_format( $order_subtotal, $decimals, $decimal_separator, $thousand_separator ),
				'order_currency'     => get_woocommerce_currency_symbol( $order->get_currency() ),
				'cart_total'         => number_format( $cart_total, $decimals, $decimal_separator, $thousand_separator ),
				'tax_totals'         => ( $tax_total ) ? number_format( $tax_total, $decimals, $decimal_separator, $thousand_separator ) : 0,
				'order_created_date' => $order->get_date_created()->format( get_option( 'date_format', 'd-m-Y' ) ),
			);
			$payment = $order->get_checkout_payment_url();
			$order_details_arr       = array(
				'shipping_details' => $shipping_details,
				'billing_details'  => $billing_details,
				'product_details'  => $order_product_details,
				'payment_url' => $payment,
			);
			return wp_json_encode( $order_details_arr );
		}
		return false;
	}
}
