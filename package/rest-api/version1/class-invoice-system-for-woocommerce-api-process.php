<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Invoice_system_for_woocommerce
 * @subpackage Invoice_system_for_woocommerce/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Invoice_System_For_Woocommerce_Api_Process' ) ) {

	/**
	 * The plugin API class.
	 *
	 * This is used to define the functions and data manipulation for custom endpoints.
	 *
	 * @since      1.0.0
	 * @package    Invoice_system_for_woocommere
	 * @subpackage Invoice_system_for_woocommere/includes
	 * @author     MakeWebBetter <makewebbetter.com>
	 */
	class Invoice_System_For_Woocommerce_Api_Process {

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {

		}

		/**
		 * Define the function to process data for custom endpoint.
		 *
		 * @since    1.0.0
		 * @param   object $isfw_request  data of requesting headers and other information.
		 * @return  Array $mwb_isfw_rest_response    returns processed data and status of operations.
		 */
		public function mwb_isfw_default_process( $isfw_request ) {
			$mwb_isfw_rest_response = array();

			// Write your custom code here.

			$mwb_isfw_rest_response['status'] = 200;
			$mwb_isfw_rest_response['data']   = $isfw_request->get_headers();
			return $mwb_isfw_rest_response;
		}
	}
}
