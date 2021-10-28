<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.2
 *
 * @package    Invoice_system_for_woocommerce
 * @subpackage Invoice_system_for_woocommerce/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\FontMetrics;

/**
 * Generate invoice global function.
 * make sure output buffer before calling this function is off
 * i.e, no echo, print_r, var_dump, _e or similar function should execute before calling this function.
 * best hook to use this function is init calling before this hook may give blank PDF.
 *
 * @since 1.0.2
 * @param int    $order_id current order id to generate invoice for.
 * @param string $type type of pdf to generate , values can be 'invoice', 'packing_slip'.
 * @param string $action action after generating invoice , values can be 'download_locally', 'open_window', 'download_on_server'.
 * @return string|void will returns path to the file if $action = download_on_server.
 */
function mwb_generate_invoice( $order_id, $type = 'invoice', $action = 'download_locally' ) {
	if ( defined( 'INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH' ) ) {
		require_once INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'common/class-invoice-system-for-woocommerce-common.php';
		$common_class = new Invoice_System_For_Woocommerce_Common( 'Invoice System For WooCommerce', '1.0.2' );
		return $common_class->isfw_common_generate_pdf( $order_id, $type, $action );
	}
}


if ( ! function_exists( 'mwb_generate_pdf' ) ) {

	/**
	 * Main function for generating pdf.
	 *
	 * @param array $args array containing the arguments.
	 *
	 * @return string|bool
	 */
	function mwb_generate_pdf( $args = array() ) {
		$attr = wp_parse_args(
			$args,
			array(
				'html'             => '',
				'paper_size'       => 'a4',
				'page_orientation' => 'portrait',
				'file_name'        => 'document.pdf',
				'Attachment'       => 1,
				'compress'         => 1,
				'get_content'      => false,
				'upload_file'      => false,
				'file_path'        => '',
			)
		);

		$dompdf = mwb_get_dompdf_object();
		$dompdf->loadHtml( $attr['html'] );
		$dompdf->setPaper( mwb_get_page_sizes( $attr['paper_size'] ), $attr['page_orientation'] );
		$dompdf->render();
		$output = $dompdf->output();
		if ( $attr['get_content'] ) {
			return $output;
		}
		if ( $attr['upload_file'] ) {
			return file_put_contents( $attr['file_path'], $output ); //phpcs:ignore WordPress
		}
		$dompdf->stream(
			$attr['file_name'],
			array(
				'compress'   => $attr['compress'],
				'Attachment' => $attr['Attachment'],
			)
		);
	}

	/**
	 * Get dompdf object.
	 *
	 * @return object
	 */
	function mwb_get_dompdf_object() {
		require_once INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'package/lib/dompdf/vendor/autoload.php';
		$dompdf = new Dompdf( array( 'enable_remote' => true ) );
		return $dompdf;
	}
	/**
	 * Get paper sizes.
	 *
	 * @param string $page_size page size to generate PDF on.
	 * @return array array containing page size.
	 */
	function mwb_get_page_sizes( $page_size = 'a4' ) {
		$paper_sizes = array(
			'4a0'                      => array( 0, 0, 4767.87, 6740.79 ),
			'2a0'                      => array( 0, 0, 3370.39, 4767.87 ),
			'a0'                       => array( 0, 0, 2383.94, 3370.39 ),
			'a1'                       => array( 0, 0, 1683.78, 2383.94 ),
			'a2'                       => array( 0, 0, 1190.55, 1683.78 ),
			'a3'                       => array( 0, 0, 841.89, 1190.55 ),
			'a4'                       => array( 0, 0, 595.28, 841.89 ),
			'a5'                       => array( 0, 0, 419.53, 595.28 ),
			'a6'                       => array( 0, 0, 297.64, 419.53 ),
			'b0'                       => array( 0, 0, 2834.65, 4008.19 ),
			'b1'                       => array( 0, 0, 2004.09, 2834.65 ),
			'b2'                       => array( 0, 0, 1417.32, 2004.09 ),
			'b3'                       => array( 0, 0, 1000.63, 1417.32 ),
			'b4'                       => array( 0, 0, 708.66, 1000.63 ),
			'b5'                       => array( 0, 0, 498.90, 708.66 ),
			'b6'                       => array( 0, 0, 354.33, 498.90 ),
			'c0'                       => array( 0, 0, 2599.37, 3676.54 ),
			'c1'                       => array( 0, 0, 1836.85, 2599.37 ),
			'c2'                       => array( 0, 0, 1298.27, 1836.85 ),
			'c3'                       => array( 0, 0, 918.43, 1298.27 ),
			'c4'                       => array( 0, 0, 649.13, 918.43 ),
			'c5'                       => array( 0, 0, 459.21, 649.13 ),
			'c6'                       => array( 0, 0, 323.15, 459.21 ),
			'ra0'                      => array( 0, 0, 2437.80, 3458.27 ),
			'ra1'                      => array( 0, 0, 1729.13, 2437.80 ),
			'ra2'                      => array( 0, 0, 1218.90, 1729.13 ),
			'ra3'                      => array( 0, 0, 864.57, 1218.90 ),
			'ra4'                      => array( 0, 0, 609.45, 864.57 ),
			'sra0'                     => array( 0, 0, 2551.18, 3628.35 ),
			'sra1'                     => array( 0, 0, 1814.17, 2551.18 ),
			'sra2'                     => array( 0, 0, 1275.59, 1814.17 ),
			'sra3'                     => array( 0, 0, 907.09, 1275.59 ),
			'sra4'                     => array( 0, 0, 637.80, 907.09 ),
			'letter'                   => array( 0, 0, 612.00, 792.00 ),
			'legal'                    => array( 0, 0, 612.00, 1008.00 ),
			'ledger'                   => array( 0, 0, 1224.00, 792.00 ),
			'tabloid'                  => array( 0, 0, 792.00, 1224.00 ),
			'executive'                => array( 0, 0, 521.86, 756.00 ),
			'folio'                    => array( 0, 0, 612.00, 936.00 ),
			'commercial #10 envelope'  => array( 0, 0, 684, 297 ),
			'catalog #10 1/2 envelope' => array( 0, 0, 648, 864 ),
			'8.5x11'                   => array( 0, 0, 612.00, 792.00 ),
			'8.5x14'                   => array( 0, 0, 612.00, 1008.0 ),
			'11x17'                    => array( 0, 0, 792.00, 1224.00 ),
		);
		return isset( $paper_sizes[ $page_size ] ) ? $paper_sizes[ $page_size ] : array( 0, 0, 595.28, 841.89 );
	}
}

