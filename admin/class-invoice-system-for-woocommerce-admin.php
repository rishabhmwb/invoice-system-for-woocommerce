<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Invoice_system_for_woocommerce
 * @subpackage Invoice_system_for_woocommerce/admin
 */

use Dompdf\Dompdf;
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Invoice_system_for_woocommerce
 * @subpackage Invoice_system_for_woocommerce/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Invoice_System_For_Woocommerce_Admin {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function isfw_admin_enqueue_styles( $hook ) {
		$screen = get_current_screen();
		if ( isset( $screen->id ) && 'makewebbetter_page_invoice_system_for_woocommerce_menu' === $screen->id ) {

			wp_enqueue_style( 'mwb-isfw-select2-css', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/invoice-system-for-woocommerce-select2.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-isfw-meterial-css', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-isfw-meterial-css2', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-isfw-meterial-lite', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-isfw-meterial-icons-css', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/icon.css', array(), time(), 'all' );

			wp_enqueue_style( $this->plugin_name . '-admin-global', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/scss/invoice-system-for-woocommerce-admin-global.css', array( 'mwb-isfw-meterial-icons-css' ), time(), 'all' );

			wp_enqueue_style( $this->plugin_name, INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/scss/invoice-system-for-woocommerce-admin.scss', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function isfw_admin_enqueue_scripts( $hook ) {

		$screen = get_current_screen();
		if ( isset( $screen->id ) && 'makewebbetter_page_invoice_system_for_woocommerce_menu' === $screen->id ) {
			wp_enqueue_script( 'mwb-isfw-select2', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/invoice-system-for-woocommerce-select2.js', array( 'jquery' ), time(), false );

			wp_enqueue_script( 'mwb-isfw-metarial-js', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-isfw-metarial-js2', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-isfw-metarial-lite', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.js', array(), time(), false );

			wp_register_script( $this->plugin_name . 'admin-js', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/js/invoice-system-for-woocommerce-admin.js', array( 'jquery', 'mwb-isfw-select2', 'mwb-isfw-metarial-js', 'mwb-isfw-metarial-js2', 'mwb-isfw-metarial-lite' ), $this->version, false );

			wp_localize_script(
				$this->plugin_name . 'admin-js',
				'isfw_admin_param',
				array(
					'ajaxurl'             => admin_url( 'admin-ajax.php' ),
					'reloadurl'           => admin_url( 'admin.php?page=invoice_system_for_woocommerce_menu' ),
					'isfw_gen_tab_enable' => get_option( 'isfw_radio_switch_demo' ),
				)
			);

			wp_enqueue_script( $this->plugin_name . 'admin-js' );
		}
		wp_enqueue_script( 'mwb-isfw-pdf-general-settings', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/js/invoice-system-for-woocommerce-admin-pdfsettings.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_media();
		wp_localize_script(
			'mwb-isfw-pdf-general-settings',
			'isfw_general_settings',
			array(
				'ajaxurl'                 => admin_url( 'admin-ajax.php' ),
				'isfw_setting_page_nonce' => wp_create_nonce( 'isfw_general_setting_nonce' ),
				'insert_image'            => __( 'Choose Image', 'invoice-system-for-woocommerce' ),
				'digit_limit'             => __( 'Please enter the digit in the digit field less then 10', 'invoice-system-for-woocommerce' ),
				'suffix_limit'            => __( 'Please Enter Characters, Numbers and "-" only in prefix and suffix field', 'invoice-system-for-woocommerce' ),
				'btn_load'                => INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/loader.gif',
				'btn_success'             => __( 'Saved', 'invoice-system-for-woocommerce' ),
				'btn_resubmit'            => __( 'Resubmit', 'invoice-system-for-woocommerce' ),
				'saving_error'            => __( 'there might be some error in saving the settings please try again', 'invoice-system-for-woocommerce' ),
			)
		);
	}

	/**
	 * Adding settings menu for invoice-system-for-woocommerce.
	 *
	 * @since    1.0.0
	 */
	public function isfw_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( __( 'MakeWebBetter', 'invoice-system-for-woocommerce' ), __( 'MakeWebBetter', 'invoice-system-for-woocommerce' ), 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/mwb-logo.png', 15 );
			$isfw_menus = apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $isfw_menus ) && ! empty( $isfw_menus ) ) {
				foreach ( $isfw_menus as $isfw_key => $isfw_value ) {
					add_submenu_page( 'mwb-plugins', $isfw_value['name'], $isfw_value['name'], 'manage_options', $isfw_value['menu_link'], array( $isfw_value['instance'], $isfw_value['function'] ) );
				}
			}
		}
	}

	/**
	 * Removing default submenu of parent menu in backend dashboard
	 *
	 * @since   1.0.0
	 */
	public function mwb_isfw_remove_default_submenu() {
		global $submenu;
		if ( is_array( $submenu ) && array_key_exists( 'mwb-plugins', $submenu ) ) {
			if ( isset( $submenu['mwb-plugins'][0] ) ) {
				unset( $submenu['mwb-plugins'][0] );
			}
		}
	}


	/**
	 * Invoice-system-for-woocommerce isfw_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function isfw_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'      => __( 'invoice-system-for-woocommerce', 'invoice-system-for-woocommerce' ),
			'slug'      => 'invoice_system_for_woocommerce_menu',
			'menu_link' => 'invoice_system_for_woocommerce_menu',
			'instance'  => $this,
			'function'  => 'isfw_options_menu_html',
		);
		return $menus;
	}


	/**
	 * Invoice-system-for-woocommerce mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			require INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * Invoice-system-for-woocommerce admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function isfw_options_menu_html() {

		include_once INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/invoice-system-for-woocommerce-admin-dashboard.php';
	}
	/**
	 * General setting page for pdf.
	 *
	 * @param array $isfw_template_pdf_settings array containing the html for the fields.
	 * @return array
	 */
	public function isfw_template_pdf_settings_page( $isfw_template_pdf_settings ) {
		$isfw_pdf_settings = get_option( 'mwb_isfw_pdf_general_settings' );
		if ( $isfw_pdf_settings ) {
			$prefix             = array_key_exists( 'prefix', $isfw_pdf_settings ) ? $isfw_pdf_settings['prefix'] : '';
			$suffix             = array_key_exists( 'suffix', $isfw_pdf_settings ) ? $isfw_pdf_settings['suffix'] : '';
			$digit              = array_key_exists( 'digit', $isfw_pdf_settings ) ? $isfw_pdf_settings['digit'] : '';
			$logo               = array_key_exists( 'logo', $isfw_pdf_settings ) ? $isfw_pdf_settings['logo'] : '';
			$date               = array_key_exists( 'date', $isfw_pdf_settings ) ? $isfw_pdf_settings['date'] : '';
			$disclaimer         = array_key_exists( 'disclaimer', $isfw_pdf_settings ) ? $isfw_pdf_settings['disclaimer'] : '';
			$color              = array_key_exists( 'color', $isfw_pdf_settings ) ? $isfw_pdf_settings['color'] : '';
			$order_status       = array_key_exists( 'order_status', $isfw_pdf_settings ) ? $isfw_pdf_settings['order_status'] : array();
			$company_name       = array_key_exists( 'company_name', $isfw_pdf_settings ) ? $isfw_pdf_settings['company_name'] : '';
			$company_city       = array_key_exists( 'company_city', $isfw_pdf_settings ) ? $isfw_pdf_settings['company_city'] : '';
			$company_state      = array_key_exists( 'company_state', $isfw_pdf_settings ) ? $isfw_pdf_settings['company_state'] : '';
			$company_pin        = array_key_exists( 'company_pin', $isfw_pdf_settings ) ? $isfw_pdf_settings['company_pin'] : '';
			$company_phone      = array_key_exists( 'company_phone', $isfw_pdf_settings ) ? $isfw_pdf_settings['company_phone'] : '';
			$company_email      = array_key_exists( 'company_email', $isfw_pdf_settings ) ? $isfw_pdf_settings['company_email'] : '';
			$company_address    = array_key_exists( 'company_address', $isfw_pdf_settings ) ? $isfw_pdf_settings['company_address'] : '';
			$template           = array_key_exists( 'template', $isfw_pdf_settings ) ? $isfw_pdf_settings['template'] : 'one';
			$is_add_logo        = array_key_exists( 'is_add_logo', $isfw_pdf_settings ) ? $isfw_pdf_settings['is_add_logo'] : '';
			$isfw_enable_plugin = array_key_exists( 'isfw_enable_plugin', $isfw_pdf_settings ) ? $isfw_pdf_settings['isfw_enable_plugin'] : '';
		} else {
			$prefix             = '';
			$suffix             = '';
			$digit              = '';
			$date               = date( 'Y-m-d' );
			$disclaimer         = '';
			$color              = '#000000';
			$logo               = '';
			$order_status       = array();
			$company_name       = '';
			$company_city       = '';
			$company_state      = '';
			$company_pin        = '';
			$company_phone      = '';
			$company_email      = '';
			$company_address    = '';
			$template           = 'one';
			$is_add_logo        = 'no';
			$isfw_enable_plugin = '';

		}
		$order_stat = wc_get_order_statuses();
		$temp       = array();
		// appending the default value.
		is_array( $order_stat ) ? $temp['wc-never'] = __( 'Never', 'invoice-system-for-woocommerce' ) : '';
		// combining the value never to the statuses array.
		$order_statuses = $temp + $order_stat;
		// array of html for pdf setting fields.
		$isfw_template_pdf_settings = array(
			array(
				'title'       => __( 'Enable plugin', 'invoice-system-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable this to start the functionality for users.', 'invoice-system-for-woocommerce' ),
				'id'          => 'mwb_enable isfw-radio-switch-id',
				'value'       => $isfw_enable_plugin,
				'class'       => 'isfw-radio-switch-class',
				'name'        => 'isfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'invoice-system-for-woocommerce' ),
					'no'  => __( 'NO', 'invoice-system-for-woocommerce' ),
				),
			),
			array(
				'title' => __( 'Company Details', 'invoice-system-for-woocommere' ),
				'type'  => 'multi',
				'id'    => 'isfw_company_details',
				'value' => array(
					array(
						'title'       => __( 'Name', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_company_name',
						'class'       => 'isfw_company_name',
						'value'       => $company_name,
						'name'        => 'isfw_company_name',
						'placeholder' => __( 'name', 'invoice-system-for-woocommerce' ),
					),
					array(
						'title'       => __( 'Address', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_company_address',
						'class'       => 'isfw_company_address',
						'value'       => $company_address,
						'name'        => 'isfw_company_address',
						'placeholder' => __( 'address', 'invoice-system-for-woocommerce' ),
					),
					array(
						'title'       => __( 'City', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_company_city',
						'class'       => 'isfw_company_city',
						'value'       => $company_city,
						'name'        => 'isfw_company_city',
						'placeholder' => __( 'city', 'invoice-system-for-woocommerce' ),
					),
				),
			),
			array(
				'type'  => 'multi',
				'id'    => 'isfw_company_details',
				'value' => array(
					array(
						'title'       => __( 'State', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_company_state',
						'class'       => 'isfw_company_state',
						'value'       => $company_state,
						'name'        => 'isfw_company_state',
						'placeholder' => __( 'state', 'invoice-system-for-woocommerce' ),
					),
					array(
						'title'       => __( 'Pin', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_company_pin',
						'class'       => 'isfw_company_pin',
						'value'       => $company_pin,
						'name'        => 'isfw_company_pin',
						'placeholder' => __( 'pin', 'invoice-system-for-woocommerce' ),
					),
					array(
						'title'       => __( 'Phone', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_company_phone',
						'class'       => 'isfw_company_phone',
						'value'       => $company_phone,
						'name'        => 'isfw_company_phone',
						'placeholder' => __( 'phone', 'invoice-system-for-woocommerce' ),
					),
				),
			),
			array(
				'type'        => 'multi',
				'id'          => 'isfw_company_details',
				'description' => __( 'These Details will be shown on invoice or packing slip', 'invoice-system-for-woocommere' ),
				'value'       => array(
					array(
						'title'       => __( 'Email', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_company_email',
						'class'       => 'isfw_company_email',
						'value'       => $company_email,
						'name'        => 'isfw_company_email',
						'placeholder' => __( 'email', 'invoice-system-for-woocommerce' ),
					),
				),
			),
			array(
				'title'       => __( 'Invoice Number', 'invoice-system-for-woocommere' ),
				'type'        => 'multi',
				'id'          => 'isfw_invoice_number',
				'description' => __( 'This combination will be used as the invoice number', 'invoice-system-for-woocommere' ),
				'value'       => array(
					array(
						'title'       => __( 'Prefix', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_invoice_number_prefix',
						'class'       => 'isfw_invoice_number_prefix',
						'value'       => $prefix,
						'name'        => 'isfw_invoice_number_prefix',
						'placeholder' => __( 'Prefix', 'invoice-system-for-woocommerce' ),
					),
					array(
						'title'       => __( 'Digit', 'invoice-system-for-woocommerce' ),
						'type'        => 'number',
						'id'          => 'isfw_invoice_number_digit',
						'class'       => 'isfw_invoice_number_digit',
						'value'       => $digit,
						'name'        => 'isfw_invoice_number_digit',
						'placeholder' => __( 'digit', 'invoice-system-for-woocommerce' ),
					),
					array(
						'title'       => __( 'Suffix', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_invoice_number_suffix',
						'class'       => 'isfw_invoice_number_suffix',
						'value'       => $suffix,
						'name'        => 'isfw_invoice_number_suffix',
						'placeholder' => __( 'suffix', 'invoice-system-for-woocommerce' ),
					),
				),
			),
			array(
				'title'       => __( 'Invoice Number Renew date', 'invoice-system-for-woocommere' ),
				'type'        => 'date',
				'description' => __( 'Please choose the invoice number renew date', 'invoice-system-for-woocommere' ),
				'id'          => 'isfw_invoice_renew_date',
				'class'       => 'isfw_invoice_renew_date',
				'value'       => $date,
			),
			array(
				'title'       => __( 'Disclaimer', 'invoice-system-for-woocommere' ),
				'type'        => 'textarea',
				'description' => __( 'Please enter desclaimer of you choice', 'invoice-system-for-woocommere' ),
				'id'          => 'isfw_invoice_disclaimer',
				'class'       => 'isfw_invoice_disclaimer',
				'value'       => $disclaimer,

			),
			array(
				'title'       => __( 'Color', 'invoice-system-for-woocommere' ),
				'type'        => 'color',
				'class'       => 'isfw_invoice_color',
				'id'          => 'isfw_invoice_color',
				'description' => __( 'Choose color of your choice', 'invoice-system-for-woocommere' ),
				'value'       => $color,
			),
			array(
				'title'       => __( 'Choose logo', 'invoice-system-for-woocommere' ),
				'type'        => 'upload-button',
				'button_text' => __( 'Upload Image', 'invoice-system-for-woocommere' ),
				'class'       => 'isfw-logo-upload_image',
				'id'          => 'isfw-logo-upload_image',
				'img-tag'     => array(
					'img-class' => 'mwb-isfw-logo-image',
					'img-id'    => 'mwb-isfw-logo-image',
					'img-style' => ( $logo ) ? 'margin:10px;' : 'display:none;margin:10px;',
					'img-src'   => $logo,
				),
			),
			array(
				'type'  => 'hidden',
				'value' => '',
				'class' => 'wp_attachment_id',
				'id'    => 'wp_attachment_id',
				'name'  => 'attachment_id',
			),
			array(
				'title'       => __( 'Add logo on invoice', 'invoice-system-for-woocommere' ),
				'type'        => 'checkbox',
				'description' => __( 'Please select if you want the above selected image to be used on invoice.', 'invoice-system-for-woocommere' ),
				'id'          => 'isfw_is_add_logo_invoice',
				'value'       => ( 'yes' === $is_add_logo ) ? '1' : '',
				'class'       => 'isfw_is_add_logo_invoice',
				'name'        => 'isfw_is_add_logo_invoice',
			),
			array(
				'title'       => __( 'Choose Template', 'invoice-system-for-woocommere' ),
				'type'        => 'multi',
				'id'          => 'isfw_invoice_template',
				'description' => __( 'This template will be used as the invoice and packing slip', 'invoice-system-for-woocommere' ),
				'value'       => array(
					array(
						'title' => __( 'Template1', 'invoice-system-for-woocommerce' ),
						'type'  => 'checkbox',
						'id'    => 'isfw_invoice_template1',
						'class' => 'isfw_invoice_template1',
						'src'   => INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/email-icon.png',
						'name'  => 'isfw_invoice_template1',
						'alt'   => 'Template1',
						'style' => 'style=max-height:500px;max-width:200px;padding:0px;',
						'value' => ( 'one' === $template ) ? 'isfw_invoice_template1' : '',
					),
					array(
						'title' => __( 'Template2', 'invoice-system-for-woocommerce' ),
						'type'  => 'checkbox',
						'id'    => 'isfw_invoice_template2',
						'class' => 'isfw_invoice_template2',
						'src'   => INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/email-icon.png',
						'name'  => 'isfw_invoice_template2',
						'alt'   => 'Template2',
						'style' => 'style=max-height:500px;max-width:200px;padding:0px;',
						'value' => ( 'two' === $template ) ? 'isfw_invoice_template2' : '',
					),
				),
			),
			array(
				'title'       => __( 'Send invoice for', 'invoice-system-for-woocommere' ),
				'type'        => 'select',
				'description' => __( 'Please choose the status of orders to send invoice for. If you do not want to send invoice please choose never.', 'invoice-system-for-woocommere' ),
				'id'          => 'isfw_send_invoice_for',
				'value'       => $order_status,
				'class'       => 'isfw-select-class',
				'placeholder' => '',
				'options'     => ( $order_statuses ) ? $order_statuses : array(),
			),
			array(
				'type'        => 'button',
				'id'          => 'isfw_invoice_general_setting_save',
				'button_text' => __( 'Save settings', 'invoice-system-for-woocommere' ),
				'class'       => 'isfw_invoice_general_setting_save',
			),
		);
		return $isfw_template_pdf_settings;
	}
	/**
	 * Aajax request handling for saving general settings for isfw pdf.
	 *
	 * @return void
	 */
	public function isfw_save_general_pdf_settings() {
		check_ajax_referer( 'isfw_general_setting_nonce', 'nonce' );
		$settings_data      = array_key_exists( 'settings_data', $_POST ) ? $_POST['settings_data'] : '';
		$isfw_enable_plugin = array_key_exists( 'isfw_enable_plugin', $_POST ) ? $_POST['isfw_enable_plugin'] : 'off';
		update_option( 'mwb_isfw_pdf_general_settings', $settings_data );
		update_option( 'isfw_mwb_plugin_enable', $isfw_enable_plugin );
		esc_html_e( 'updated successfully', 'invoice-system-for-woocommere' );
		wp_die();
	}
	/**
	 * Adding shortcodes for fetching order details.
	 *
	 * @return void
	 */
	public function isfw_fetch_order_details_shortcode() {
		add_shortcode( 'isw_fetch_order', array( $this, 'isfw_fetch_order_details' ) );
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
	/**
	 * Populating field for custom column on order listing page.
	 *
	 * @param string $column columns.
	 * @return void
	 */
	public function isfw_populating_field_for_custom_tab( $column ) {
		global $post;
		if ( 'order_number' === $column ) {
			_e( '<div><span style="margin-left:20px;"><a href="/wp-admin/post.php?orderid='. $post->ID . '&action=generateinvoice" style="margin-left:5px;" id="isfw-print-invoice-order-listing-page" data-order-id="' . $post->ID . '"><img src="' . INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/invoice_pdf.svg" width="20" height="20" title="'. __( "Generate invoice", "invoice-system-for-woocommerce" ) .'"></a><a href="/wp-admin/post.php?orderid='. $post->ID . '&action=generateslip" style="margin-left:5px;" id="isfw-print-invoice-order-listing-page" data-order-id="' . $post->ID . '"><img src="' . INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/packing_slip.svg" width="20" height="20" title="' . __( "Generate packing slip", "invoice-system-for-woocommerce"  ) . '"></a></span></div>' );
		}
	}
	/**
	 * Creating pdf by passing order id.
	 *
	 * @return void
	 */
	public function isfw_create_pdf() {
		global $pagenow;
		if ( 'post.php' === $pagenow ) {
			if ( isset( $_GET['orderid'] ) && isset( $_GET['action'] ) ) {
				if ( 'generateinvoice' === $_GET['action'] ) {
					$order_id = sanitize_text_field( wp_unslash( $_GET['orderid'] ) );
					$this->isfw_generating_pdf( $order_id, 'invoice', 'download_locally' );
				}
				if ( 'generateslip' === $_GET['action'] ) {
					$order_id = sanitize_text_field( wp_unslash( $_GET['orderid'] ) );
					$this->isfw_generating_pdf( $order_id, 'packing_slip', 'download_locally' );
				}
			}
		}
	}
	/**
	 * Generating pdf by passing appropriate values.
	 *
	 * @param int    $order_id order id to print invoice for.
	 * @param string $type either to generate invoice or packing slip.
	 * @param string $action what action to take values can be : 'download_locally', 'open_window', 'download_on_server'.
	 * @return void
	 */
	public function isfw_generating_pdf( $order_id, $type, $action ) {
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
		ob_end_clean();
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
				file_put_contents( $path, $output );
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
				file_put_contents( $path, $output );
			}
		}
	}
	/**
	 * Attaching pdf to the email.
	 *
	 * @param array  $attachments array of attachment data.
	 * @param string $email_id status for the attachment to send.
	 * @param object $order order object.
	 * @param email  $email email to send.
	 * @return array
	 */
	public function isfw_send_attachment_with_email( $attachments, $email_id, $order, $email ) {
		$isfw_pdf_settings = get_option( 'mwb_isfw_pdf_general_settings' );
		if ( $isfw_pdf_settings ) {
			$order_status = array_key_exists( 'order_status', $isfw_pdf_settings ) ? $isfw_pdf_settings['order_status'] : '';
			if ( $order_status ) {
				$order_statuses = preg_replace( '/wc-/', 'customer_', $order_status ) . '_order';
				if ( $email_id === $order_statuses ) {
					$this->isfw_generating_pdf( $order->get_id(), 'invoice', 'download_on_server' );
					$upload_dir     = wp_upload_dir();
					$upload_basedir = $upload_dir['basedir'] . '/invoices/';
					$file           = $upload_basedir . 'invoice_' . $order->get_id() . '.pdf';
					if ( ! file_exists( $file ) ) {
						$this->isfw_generating_pdf( $order->get_id(), 'invoice', 'download_on_server' );
					}
					$attachments[] = $file;
				}
			}
		}
		return $attachments;
	}
	/**
	 * Bulk action at order listing page for downloading pdf.
	 *
	 * @param array $actions actions array containing bulk action.
	 *
	 * @return array
	 */
	public function isfw_bulk_pdf_download_order_listing_page( $actions ) {
		$actions['isfw_download_invoice']      = __( 'Download Invoice', 'invoice-system-for-woocommerce' );
		$actions['isfw_download_packing_slip'] = __( 'Download Packing Slip', 'invoice-system-for-woocommerce' );
		return $actions;
	}
	/**
	 * Handling bulk action for generating pdf.
	 *
	 * @param url    $redirect_to returning url.
	 * @param string $action slug of the bulk action selected.
	 * @param array  $post_ids array of ids selected.
	 * @return url
	 */
	public function isfw_handling_bulk_action_for_pdf_generation( $redirect_to, $action, $post_ids ) {
		$processed_ids  = array();
		$zip            = new ZipArchive();
		$upload_dir     = wp_upload_dir();
		$upload_basedir = $upload_dir['basedir'] . '/invoices/';
		$zip_path       = $upload_basedir . 'document.zip';
		if ( file_exists( $zip_path ) ) {
			@unlink( $zip_path );
		}
		$zip->open( $zip_path, ZipArchive::CREATE );
		if ( 'isfw_download_invoice' === $action ) {
			foreach ( $post_ids as $order_id ) {
				$processed_ids[] = $order_id;
				$upload_dir      = wp_upload_dir();
				$upload_basedir  = $upload_dir['basedir'] . '/invoices/';
				$file_pdf_path   = $upload_basedir . 'invoice_' . $order_id . '.pdf';
				if ( ! file_exists( $file_pdf_path ) ) {
					$this->isfw_generating_pdf( $order_id, 'invoice', 'download_on_server' );
				}
				$zip->addFile( $file_pdf_path );
			}
			$zip->close();
			return $redirect_to = add_query_arg(
				array(
					'write_downloads' => '1',
					'processed_count' => count( $processed_ids ),
				),
				$redirect_to
			);
		}
		if ( 'isfw_download_packing_slip' === $action ) {
			foreach ( $post_ids as $order_id ) {
				$processed_ids[] = $order_id;
				$upload_dir      = wp_upload_dir();
				$upload_basedir  = $upload_dir['basedir'] . '/invoices/';
				$file_pdf_path   = $upload_basedir . 'packing_slip_' . $order_id . '.pdf';
				if ( ! file_exists( $file_pdf_path ) ) {
					$this->isfw_generating_pdf( $order_id, 'packing_slip', 'download_on_server' );
				}
				$zip->addFile( $file_pdf_path );
			}
			$zip->close();
			return $redirect_to = add_query_arg(
				array(
					'write_downloads' => '1',
					'processed_count' => count( $processed_ids ),
				),
				$redirect_to
			);
		}
		return $redirect_to;
	}
	/**
	 * Displaying admin notices for the selected bulk action.
	 *
	 * @return void
	 */
	public function isfw_pdf_downloads_bulk_action_admin_notice() {
		if ( empty( $_REQUEST['write_downloads'] ) ) {
			return;  // Exit.
		}
		$processed_count = sanitize_text_field( wp_unslash( $_REQUEST['processed_count'] ) );
		add_thickbox();
		?>
		<div class="updated">
		<div><?php esc_html_e( 'Files has been processed and are ready to download in zip.', 'invoice-system-for-woocommerce' ); ?></div>
		<a href="#TB_inline?width=100&height=100&inlineId=modal-window-id" class="thickbox"><?php esc_html_e( 'Click here to open panel to download', 'invoice-system-for-woocommerce' ); ?></a>
			<div id="modal-window-id" style="display:none;">
			<?php
				$upload_dir     = wp_upload_dir();
				$upload_baseurl = $upload_dir['baseurl'] . '/invoices/';
				$file_url       = $upload_baseurl . 'document.zip';
			?>
				<div>
					<?php printf( _n( '%s file has been processed', '%s files has been procesed', $processed_count, 'invoice-system-for-woocommerce' ), $processed_count ); ?>
					<a href='<?php echo esc_attr( $file_url ); ?>' id="isfw_download_zip_pdf"><?php esc_html_e( 'Download zip', 'invoice-system-for-woocommerce' ); ?></a>
				</div>
			</div>
		</div>
		<script type='text/javascript'>
			jQuery(document).ready(function($){
				setTimeout(function(){
					$(document).find('a.thickbox').trigger('click');
					$(document).find('a#isfw_download_zip_pdf').css('color', 'green');
					$(document).find('a#isfw_download_zip_pdf').trigger('click');
				}, 2000);
			});
		</script>
		<?php
	}
}
