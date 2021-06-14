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

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript
 * order details shortcode [ISFW_FETCH_ORDER order_id ='' ].
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
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'mwb-isfw-admin-custom-css', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/scss/invoice-system-for-woocommerce-admin-custom.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'date-picker-css', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/scss/date-picker.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'jquery-ui' );
		}
		wp_enqueue_style( 'mwb-isfw-global-css-for-all', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/scss/invoice-system-for-woocommerce-admin-global-for-all.css', array(), $this->version, 'all' );
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
			wp_enqueue_media();
			wp_enqueue_script( 'mwb-isfw-pdf-general-settings', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/js/invoice-system-for-woocommerce-admin-pdfsettings.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_media();
			wp_localize_script(
				'mwb-isfw-pdf-general-settings',
				'isfw_general_settings',
				array(
					'ajaxurl'                 => admin_url( 'admin-ajax.php' ),
					'isfw_setting_page_nonce' => wp_create_nonce( 'isfw_general_setting_nonce' ),
					'insert_image'            => __( 'Choose Image', 'invoice-system-for-woocommerce' ),
					'remove_image'            => __( 'Remove Image', 'invoice-system-for-woocommerce' ),
					'digit_limit'             => '<div class="notice notice-error is-dismissible">
													<p>' . __( 'Please choose digits greater then 0 and less then 10', 'invoice-system-for-woocommerce' ) . '</p>
												</div>',
					'suffix_limit'            => '<div class="notice notice-error is-dismissible">
													<p>' . __( 'Please Enter Characters, Numbers and - only, in prefix and suffix field', 'invoice-system-for-woocommerce' ) . '</p>
												</div>',
					'btn_load'                => INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/loader.gif',
					'btn_success'             => __( 'Saved', 'invoice-system-for-woocommerce' ),
					'btn_resubmit'            => __( 'Resubmit', 'invoice-system-for-woocommerce' ),
					'saving_error'            => '<div class="notice notice-error is-dismissible">
													<p>' . __( 'Error,Please reload the page and try again.', 'invoice-system-for-woocommerce' ) . '</p>
												</div>',
					'invalid_date'            => '<div class="notice notice-error is-dismissible">
													<p>' . __( 'Date can be either current year or next year. Please choose again!', 'invoice-system-for-woocommerce' ) . '</p>
												</div>',
					'calender_image'          => INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/calender.png',
				)
			);
		}
		wp_enqueue_script( 'isfw_zip-download-js', INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/js/invoice-system-for-woocommerce-zip-download.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * Adding settings menu for invoice-system-for-woocommerce.
	 *
	 * @since    1.0.0
	 */
	public function isfw_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( 'MakeWebBetter', 'MakeWebBetter', 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/MWB_Grey-01.svg', 15 );
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
			'name'      => 'Invoice System for WooCommerce',
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
	 * Save settings for admin pages.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function isfw_admin_save_tab_settings() {
		global $isfw_mwb_isfw_obj, $isfw_save_check_flag;
		if ( isset( $_POST['isfw_nonce_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['isfw_nonce_field'] ) ), 'nonce_settings_save' ) ) {
			if ( isset( $_POST['isfw_general_setting_save'] ) ) {
				$isfw_genaral_settings = apply_filters( 'isfw_template_pdf_settings_array', array() );
				$isfw_save_check_flag  = true;
			} elseif ( isset( $_POST['isfw_invoice_setting_save'] ) ) {
				$isfw_genaral_settings = apply_filters( 'isfw_template_invoice_settings_array', array() );
				$isfw_save_check_flag  = true;
			} elseif ( isset( $_POST['isfw_packing_slip_setting_save'] ) ) {
				$isfw_genaral_settings = apply_filters( 'isfw_template_packing_slip_settings_array', array() );
				$isfw_save_check_flag  = true;
			}
			if ( $isfw_save_check_flag ) {
				$mwb_isfw_gen_flag = false;
				$isfw_button_index = array_search( 'submit', array_column( $isfw_genaral_settings, 'type' ), true );
				if ( isset( $isfw_button_index ) && ( null == $isfw_button_index || '' == $isfw_button_index ) ) { // phpcs:ignore
					$isfw_button_index = array_search( 'button', array_column( $isfw_genaral_settings, 'type' ), true );
				}
				if ( isset( $isfw_button_index ) && '' !== $isfw_button_index ) {
					unset( $isfw_genaral_settings[ $isfw_button_index ] );
					if ( is_array( $isfw_genaral_settings ) && ! empty( $isfw_genaral_settings ) ) {
						foreach ( $isfw_genaral_settings as $isfw_genaral_setting ) {
							if ( isset( $isfw_genaral_setting['id'] ) && '' !== $isfw_genaral_setting['id'] ) {
								if ( 'multi' === $isfw_genaral_setting['type'] ) {
									$isfw_general_sub_array = $isfw_genaral_setting['value'];
									foreach ( $isfw_general_sub_array as $isfw_sub_settings ) {
										if ( isset( $_POST[ $isfw_sub_settings['id'] ] ) ) {
											update_option( $isfw_sub_settings['id'], sanitize_text_field( wp_unslash( $_POST[ $isfw_sub_settings['id'] ] ) ) );
										} else {
											update_option( $isfw_sub_settings['id'], '' );
										}
									}
								} elseif ( 'multiwithcheck' === $isfw_genaral_setting['type'] ) {
									$isfw_general_settings_sub_arr = $isfw_genaral_setting['value'];
									$meta_keys_and_key_names       = array();
									$meta_keys_and_checkbox_state  = array();
									foreach ( $isfw_general_settings_sub_arr as $isfw_sub_genaral_setting ) {
										if ( isset( $_POST[ $isfw_sub_genaral_setting['id'] ] ) ) {
											$meta_keys_and_key_names[ $isfw_sub_genaral_setting['id'] ] = sanitize_text_field( wp_unslash( $_POST[ $isfw_sub_genaral_setting['id'] ] ) );
										} else {
											$meta_keys_and_key_names[ $isfw_sub_genaral_setting['id'] ] = '';

										}
										if ( isset( $_POST[ $isfw_sub_genaral_setting['checkbox_id'] ] ) ) {
											$meta_keys_and_checkbox_state[ $isfw_sub_genaral_setting['checkbox_id'] ] = sanitize_text_field( wp_unslash( $_POST[ $isfw_sub_genaral_setting['checkbox_id'] ] ) );
										} else {
											$meta_keys_and_checkbox_state[ $isfw_sub_genaral_setting['checkbox_id'] ] = '';
										}
									}
									update_option( $isfw_genaral_setting['id'], $meta_keys_and_key_names );
									update_option( $isfw_genaral_setting['id'] . '_checkbox', $meta_keys_and_checkbox_state );
								} elseif ( 'date-picker' === $isfw_genaral_setting['type'] ) {
									$isfw_sub_genaral_setting_month_value = $isfw_genaral_setting['value']['month'];
									$isfw_sub_genaral_setting_date_value  = $isfw_genaral_setting['value']['date'];
									if ( isset( $_POST[ $isfw_sub_genaral_setting_month_value['id'] ] ) ) {
										update_option( $isfw_sub_genaral_setting_month_value['id'], sanitize_text_field( wp_unslash( $_POST[ $isfw_sub_genaral_setting_month_value['id'] ] ) ) );
									} else {
										update_option( $isfw_sub_genaral_setting_month_value['id'], '' );
									}
									if ( isset( $_POST[ $isfw_sub_genaral_setting_date_value['id'] ] ) ) {
										update_option( $isfw_sub_genaral_setting_date_value['id'], sanitize_text_field( wp_unslash( $_POST[ $isfw_sub_genaral_setting_date_value['id'] ] ) ) );
									} else {
										update_option( $isfw_sub_genaral_setting_date_value['id'], '' );
									}
								} else {
									if ( isset( $_POST[ $isfw_genaral_setting['id'] ] ) ) {
										$value = is_array( $_POST[ $isfw_genaral_setting['id'] ] ) ? map_deep( wp_unslash( $_POST[ $isfw_genaral_setting['id'] ] ), 'sanitize_text_field' ) : sanitize_text_field( wp_unslash( $_POST[ $isfw_genaral_setting['id'] ] ) );
										update_option( $isfw_genaral_setting['id'], $value );
									} else {
										update_option( $isfw_genaral_setting['id'], '' );
									}
								}
							}
						}
					}
				}
			}
		}
	}
	/**
	 * General setting page for pdf.
	 *
	 * @param array $isfw_template_pdf_settings array containing the html for the fields.
	 * @return array
	 */
	public function isfw_template_pdf_settings_page( $isfw_template_pdf_settings ) {
		$isfw_send_invoice_automatically          = get_option( 'isfw_send_invoice_automatically' );
		$isfw_send_invoice_for                    = get_option( 'isfw_send_invoice_for' );
		$isfw_allow_invoice_generation_for_orders = get_option( 'isfw_allow_invoice_generation_for_orders', array() );
		$isfw_generate_invoice_from_cache         = get_option( 'isfw_generate_invoice_from_cache' );
		$order_stat                               = wc_get_order_statuses();
		$temp                                     = array(
			'wc-never' => __( 'Never', 'invoice-system-for-woocommerce' ),
		);
		// appending the default value.
		$order_statuses = is_array( $order_stat ) ? $temp + $order_stat : $temp;
		// array of html for pdf setting fields.
		$isfw_template_pdf_settings   = array(
			array(
				'title'       => __( 'Enable plugin', 'invoice-system-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable this to start the plugin functionality for users.', 'invoice-system-for-woocommerce' ),
				'id'          => 'isfw_enable_plugin',
				'value'       => get_option( 'isfw_enable_plugin' ),
				'class'       => 'isfw_enable_plugin',
				'name'        => 'isfw_enable_plugin',
			),
			array(
				'title'       => __( 'Automatically Attach invoice', 'invoice-system-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable this to attach invoices with woocommerce mails.', 'invoice-system-for-woocommerce' ),
				'id'          => 'isfw_send_invoice_automatically',
				'value'       => $isfw_send_invoice_automatically,
				'class'       => 'isfw_send_invoice_automatically',
				'name'        => 'isfw_send_invoice_automatically',
			),
			array(
				'title'       => __( 'Order Status to Send Invoice for', 'invoice-system-for-woocommere' ),
				'type'        => 'select',
				'description' => __( 'Please choose the status of orders to send invoice for. If you do not want to send invoice please choose never.', 'invoice-system-for-woocommere' ),
				'id'          => 'isfw_send_invoice_for',
				'value'       => $isfw_send_invoice_for,
				'name'        => 'isfw_send_invoice_for',
				'class'       => 'isfw_send_invoice_for',
				'placeholder' => '',
				'options'     => $order_statuses,
			),
			array(
				'title'       => __( 'Download invoice for users at Order Status', 'invoice-system-for-woocommere' ),
				'type'        => 'multiselect',
				'description' => __( 'Please choose the status of orders to allow invoice download for users.', 'invoice-system-for-woocommere' ),
				'id'          => 'isfw_allow_invoice_generation_for_orders',
				'value'       => $isfw_allow_invoice_generation_for_orders,
				'name'        => 'isfw_allow_invoice_generation_for_orders',
				'class'       => 'isfw_allow_invoice_generation_for_orders isfw-multiselect-class mwb-defaut-multiselect',
				'placeholder' => '',
				'options'     => $order_statuses,
			),
			array(
				'title'       => __( 'Generate invoice from cache', 'invoice-system-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable this to generate invoices from cache( invoices once downloaded will be stored in the preferred location and will be used later ), please note that once this is enabled changes after invoice generation will not reflect for earlier invoices, however changes will work for new order invoice downloads.', 'invoice-system-for-woocommerce' ),
				'id'          => 'isfw_generate_invoice_from_cache',
				'value'       => $isfw_generate_invoice_from_cache,
				'class'       => 'isfw_generate_invoice_from_cache',
				'name'        => 'isfw_generate_invoice_from_cache',
			),
		);
		$isfw_template_pdf_settings   = apply_filters( 'isfw_template_pdf_settings_array_filter', $isfw_template_pdf_settings );
		$isfw_template_pdf_settings[] = array(
			'type'        => 'button',
			'id'          => 'isfw_general_setting_save',
			'button_text' => __( 'Save settings', 'invoice-system-for-woocommere' ),
			'class'       => 'isfw_general_setting_save',
			'name'        => 'isfw_general_setting_save',
		);
		return $isfw_template_pdf_settings;
	}
	/**
	 * Invoice settting html array.
	 *
	 * @param array $invoice_settings_arr invoice setting array fields.
	 * @since 1.0.0
	 * @return array
	 */
	public function isfw_template_invoice_setting_html_fields( $invoice_settings_arr ) {
		$isfw_company_name                    = get_option( 'isfw_company_name' );
		$isfw_company_address                 = get_option( 'isfw_company_address' );
		$isfw_company_city                    = get_option( 'isfw_company_city' );
		$isfw_company_state                   = get_option( 'isfw_company_state' );
		$isfw_company_pin                     = get_option( 'isfw_company_pin' );
		$isfw_company_phone                   = get_option( 'isfw_company_phone' );
		$isfw_company_email                   = get_option( 'isfw_company_email' );
		$isfw_invoice_number_digit            = get_option( 'isfw_invoice_number_digit' );
		$isfw_invoice_number_prefix           = get_option( 'isfw_invoice_number_prefix' );
		$isfw_invoice_number_suffix           = get_option( 'isfw_invoice_number_suffix' );
		$isfw_invoice_disclaimer              = get_option( 'isfw_invoice_disclaimer' );
		$isfw_invoice_color                   = get_option( 'isfw_invoice_color' );
		$isfw_is_add_logo_invoice             = get_option( 'isfw_is_add_logo_invoice' );
		$sub_isfw_upload_invoice_company_logo = get_option( 'sub_isfw_upload_invoice_company_logo' );
		$isfw_invoice_template                = get_option( 'isfw_invoice_template' );
		$isfw_invoice_number_renew_month      = get_option( 'isfw_invoice_number_renew_month' );
		$isfw_invoice_number_renew_date       = get_option( 'isfw_invoice_number_renew_date' );
		$isfw_months                          = array(
			'never' => __( 'Never', 'invoice-system-for-woocommerce' ),
			1       => __( 'January', 'invoice-system-for-woocommerce' ),
			2       => __( 'February', 'invoice-system-for-woocommerce' ),
			3       => __( 'March', 'invoice-system-for-woocommerce' ),
			4       => __( 'April', 'invoice-system-for-woocommerce' ),
			5       => __( 'May', 'invoice-system-for-woocommerce' ),
			6       => __( 'June', 'invoice-system-for-woocommerce' ),
			7       => __( 'July', 'invoice-system-for-woocommerce' ),
			8       => __( 'August', 'invoice-system-for-woocommerce' ),
			9       => __( 'September', 'invoice-system-for-woocommerce' ),
			10      => __( 'October', 'invoice-system-for-woocommerce' ),
			11      => __( 'November', 'invoice-system-for-woocommerce' ),
			12      => __( 'December', 'invoice-system-for-woocommerce' ),
		);

		if ( ( 'never' !== $isfw_invoice_number_renew_month ) && ( $isfw_invoice_number_renew_month && '' !== $isfw_invoice_number_renew_month ) ) {
			$number_of_days = cal_days_in_month( CAL_GREGORIAN, $isfw_invoice_number_renew_month, gmdate( 'Y' ) );
			$dates          = range( 1, $number_of_days );
			$isfw_date      = array_combine( $dates, $dates );
		} else {
			$isfw_date = '';
		}

		$invoice_settings_arr = array(
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
						'value'       => $isfw_company_name,
						'name'        => 'isfw_company_name',
						'placeholder' => __( 'name', 'invoice-system-for-woocommerce' ),
					),
					array(
						'title'       => __( 'Address', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_company_address',
						'class'       => 'isfw_company_address',
						'value'       => $isfw_company_address,
						'name'        => 'isfw_company_address',
						'placeholder' => __( 'address', 'invoice-system-for-woocommerce' ),
					),
					array(
						'title'       => __( 'City', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_company_city',
						'class'       => 'isfw_company_city',
						'value'       => $isfw_company_city,
						'name'        => 'isfw_company_city',
						'placeholder' => __( 'city', 'invoice-system-for-woocommerce' ),
					),
					array(
						'title'       => __( 'State', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_company_state',
						'class'       => 'isfw_company_state',
						'value'       => $isfw_company_state,
						'name'        => 'isfw_company_state',
						'placeholder' => __( 'state', 'invoice-system-for-woocommerce' ),
					),
					array(
						'title'       => __( 'Pin', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_company_pin',
						'class'       => 'isfw_company_pin',
						'value'       => $isfw_company_pin,
						'name'        => 'isfw_company_pin',
						'placeholder' => __( 'pin', 'invoice-system-for-woocommerce' ),
					),
					array(
						'title'       => __( 'Phone', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_company_phone',
						'class'       => 'isfw_company_phone',
						'value'       => $isfw_company_phone,
						'name'        => 'isfw_company_phone',
						'placeholder' => __( 'phone', 'invoice-system-for-woocommerce' ),
					),
					array(
						'title'       => __( 'Email', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_company_email',
						'class'       => 'isfw_company_email',
						'value'       => $isfw_company_email,
						'name'        => 'isfw_company_email',
						'placeholder' => __( 'email', 'invoice-system-for-woocommerce' ),
					),
				),
			),
			array(
				'title'       => __( 'Invoice Number', 'invoice-system-for-woocommere' ),
				'type'        => 'multi',
				'id'          => 'isfw_invoice_number',
				'description' => __( 'This combination will be used as the invoice ID : prefix + number of digits + suffix.', 'invoice-system-for-woocommere' ),
				'value'       => array(
					array(
						'title'       => __( 'Prefix', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_invoice_number_prefix',
						'class'       => 'isfw_invoice_number_prefix',
						'value'       => $isfw_invoice_number_prefix,
						'name'        => 'isfw_invoice_number_prefix',
						'placeholder' => __( 'Prefix', 'invoice-system-for-woocommerce' ),
					),
					array(
						'title'       => __( 'Digit', 'invoice-system-for-woocommerce' ),
						'type'        => 'number',
						'id'          => 'isfw_invoice_number_digit',
						'class'       => 'isfw_invoice_number_digit',
						'value'       => $isfw_invoice_number_digit,
						'name'        => 'isfw_invoice_number_digit',
						'placeholder' => __( 'digit', 'invoice-system-for-woocommerce' ),
					),
					array(
						'title'       => __( 'Suffix', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_invoice_number_suffix',
						'class'       => 'isfw_invoice_number_suffix',
						'value'       => $isfw_invoice_number_suffix,
						'name'        => 'isfw_invoice_number_suffix',
						'placeholder' => __( 'suffix', 'invoice-system-for-woocommerce' ),
					),
				),
			),
			array(
				'title'       => __( 'Invoice Number Renew date', 'invoice-system-for-woocommere' ),
				'type'        => 'date-picker',
				'description' => __( 'Please choose the invoice number renew date', 'invoice-system-for-woocommere' ),
				'id'          => 'isfw_invoice_number_renew',
				'class'       => 'isfw_invoice_number_renew',
				'name'        => 'isfw_invoice_number_renew',
				'value'       => array(
					'month' => array(
						'id'      => 'isfw_invoice_number_renew_month',
						'title'   => __( 'Month', 'invoice-system-for-woocommerce' ),
						'type'    => 'select',
						'class'   => 'isfw_invoice_number_renew_month',
						'name'    => 'isfw_invoice_number_renew_month',
						'value'   => $isfw_invoice_number_renew_month,
						'options' => $isfw_months,
					),
					'date'  => array(
						'id'      => 'isfw_invoice_number_renew_date',
						'title'   => __( 'Date', 'invoice-system-for-woocommerce' ),
						'type'    => 'select',
						'class'   => 'isfw_invoice_number_renew_date',
						'name'    => 'isfw_invoice_number_renew_date',
						'value'   => $isfw_invoice_number_renew_date,
						'options' => $isfw_date,
					),
				),
			),
			array(
				'title'       => __( 'Disclaimer', 'invoice-system-for-woocommere' ),
				'type'        => 'textarea',
				'description' => __( 'Please enter desclaimer of you choice', 'invoice-system-for-woocommere' ),
				'id'          => 'isfw_invoice_disclaimer',
				'class'       => 'isfw_invoice_disclaimer',
				'value'       => $isfw_invoice_disclaimer,
				'placeholder' => __( 'disclaimer', 'invoice-system-for-woocommerce' ),
				'name'        => 'isfw_invoice_disclaimer',

			),
			array(
				'title'       => __( 'Color', 'invoice-system-for-woocommere' ),
				'type'        => 'color',
				'class'       => 'isfw_color_picker isfw_invoice_color',
				'id'          => 'isfw_invoice_color',
				'description' => __( 'Choose color of your choice for invoices', 'invoice-system-for-woocommere' ),
				'value'       => $isfw_invoice_color,
				'name'        => 'isfw_invoice_color',
			),
			array(
				'title'        => __( 'Choose company logo', 'invoice-system-for-woocommerce' ),
				'type'         => 'upload-button',
				'button_text'  => __( 'Upload Logo', 'invoice-system-for-woocommerce' ),
				'class'        => 'sub_isfw_upload_invoice_company_logo',
				'id'           => 'sub_isfw_upload_invoice_company_logo',
				'value'        => $sub_isfw_upload_invoice_company_logo,
				'sub_id'       => 'isfw_upload_invoice_company_logo',
				'sub_class'    => 'isfw_upload_invoice_company_logo',
				'sub_name'     => 'isfw_upload_invoice_company_logo',
				'name'         => 'sub_isfw_upload_invoice_company_logo',
				'parent-class' => 'mwb_pgfw_setting_separate_border',
				'description'  => '',
				'img-tag'      => array(
					'img-class' => 'isfw_invoice_company_logo_image',
					'img-id'    => 'isfw_invoice_company_logo_image',
					'img-style' => ( $sub_isfw_upload_invoice_company_logo ) ? 'margin:10px;height:100px;width:100px;' : 'display:none;margin:10px;height:100px;width:100px;',
					'img-src'   => $sub_isfw_upload_invoice_company_logo,
				),
				'img-remove'   => array(
					'btn-class' => 'isfw_invoice_company_logo_image_remove',
					'btn-id'    => 'isfw_invoice_company_logo_image_remove',
					'btn-text'  => __( 'Remove Logo', 'invoice-system-for-woocommerce' ),
					'btn-title' => __( 'Remove Logo', 'invoice-system-for-woocommerce' ),
					'btn-name'  => 'isfw_invoice_company_logo_image_remove',
					'btn-style' => ! ( $sub_isfw_upload_invoice_company_logo ) ? 'display:none' : '',
				),
			),
			array(
				'title'       => __( 'Add logo on invoice', 'invoice-system-for-woocommere' ),
				'type'        => 'checkbox',
				'description' => __( 'Please select if you want the above selected image to be used on invoice.', 'invoice-system-for-woocommere' ),
				'id'          => 'isfw_is_add_logo_invoice',
				'value'       => $isfw_is_add_logo_invoice,
				'class'       => 'isfw_is_add_logo_invoice',
				'name'        => 'isfw_is_add_logo_invoice',
			),
			array(
				'title'       => __( 'Choose Template', 'invoice-system-for-woocommere' ),
				'type'        => 'temp-select',
				'id'          => 'isfw_invoice_template',
				'description' => __( 'This template will be used as the invoice and packing slip', 'invoice-system-for-woocommere' ),
				'selected'    => $isfw_invoice_template,
				'value'       => array(
					array(
						'title' => __( 'Template1', 'invoice-system-for-woocommerce' ),
						'type'  => 'radio',
						'id'    => 'isfw_invoice_template_one',
						'class' => 'isfw_invoice_template_one',
						'name'  => 'isfw_invoice_template',
						'value' => 'one',
						'src'   => INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/template1.png',
					),
					array(
						'title' => __( 'Template2', 'invoice-system-for-woocommerce' ),
						'type'  => 'radio',
						'id'    => 'isfw_invoice_template_two',
						'class' => 'isfw_invoice_template_two',
						'src'   => INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/template2.png',
						'name'  => 'isfw_invoice_template',
						'value' => 'two',
					),
				),
			),
		);
		$invoice_settings_arr   = apply_filters( 'isfw_invoice_settings_array_filter', $invoice_settings_arr );
		$invoice_settings_arr[] = array(
			'type'        => 'button',
			'id'          => 'isfw_invoice_setting_save',
			'button_text' => __( 'Save settings', 'invoice-system-for-woocommere' ),
			'class'       => 'isfw_invoice_setting_save',
			'name'        => 'isfw_invoice_setting_save',
		);
		return $invoice_settings_arr;
	}
	/**
	 * Populating field for custom column on order listing page admin.
	 *
	 * @param string $column columns.
	 * @return void
	 */
	public function isfw_populating_field_for_custom_tab( $column ) {
		global $post;
		$post_page = admin_url( 'post.php' );
		if ( 'order_number' === $column ) {
			require INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'admin/templates/invoice-system-for-woocommerce-admin-admin-invoice-icon.php';
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
			if ( isset( $_GET['orderid'] ) && isset( $_GET['action'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				if ( 'generateinvoice' === $_GET['action'] ) { // phpcs:ignore WordPress.Security.NonceVerification
					$order_id = sanitize_text_field( wp_unslash( $_GET['orderid'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
					$this->isfw_generating_pdf( $order_id, 'invoice', 'download_locally' );
				}
				if ( 'generateslip' === $_GET['action'] ) { // phpcs:ignore WordPress.Security.NonceVerification
					$order_id = sanitize_text_field( wp_unslash( $_GET['orderid'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
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
	 * @return string
	 */
	public function isfw_generating_pdf( $order_id, $type, $action ) {
		require_once INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'common/class-invoice-system-for-woocommerce-common.php';
		$common_class = new Invoice_System_For_Woocommerce_Common( $this->plugin_name, $this->version );
		$file_path    = $common_class->isfw_common_generate_pdf( $order_id, $type, $action );
		return $file_path;
	}
	/**
	 * Attaching pdf to the email.
	 *
	 * @param array  $attachments array of attachment data.
	 * @param string $email_id status for the attachment to send.
	 * @param object $order order object.
	 * @param string $email email to send.
	 * @return array
	 */
	public function isfw_send_attachment_with_email( $attachments, $email_id, $order, $email ) {
		if ( 'yes' === get_option( 'isfw_send_invoice_automatically' ) ) {
			$order_status = get_option( 'isfw_send_invoice_for' );
			if ( $order_status ) {
				$order_statuses = preg_replace( '/wc-/', 'customer_', $order_status ) . '_order';
				if ( $email_id === $order_statuses ) {
					$path          = $this->isfw_generating_pdf( $order->get_id(), 'invoice', 'download_on_server' );
					$attachments[] = $path;
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
	 * @param string $redirect_to returning url.
	 * @param string $action slug of the bulk action selected.
	 * @param array  $post_ids array of ids selected.
	 * @return string
	 */
	public function isfw_handling_bulk_action_for_pdf_generation( $redirect_to, $action, $post_ids ) {
		$processed_ids  = array();
		$zip            = new ZipArchive();
		$upload_dir     = wp_upload_dir();
		$upload_basedir = $upload_dir['basedir'] . '/invoices/';
		$zip_path       = $upload_basedir . 'document.zip';
		if ( ! file_exists( $upload_basedir ) ) {
			wp_mkdir_p( $upload_basedir );
		}
		if ( file_exists( $zip_path ) ) {
			@unlink( $zip_path ); // phpcs:ignore
		}
		$zip->open( $zip_path, ZipArchive::CREATE );
		if ( 'isfw_download_invoice' === $action ) {
			foreach ( $post_ids as $order_id ) {
				$file_path = $this->isfw_generating_pdf( $order_id, 'invoice', 'download_on_server' );
				$zip->addFile( $file_path, str_replace( $upload_dir['basedir'], '', $file_path ) );
			}
			@$zip->close(); // phpcs:ignore
			$redirect_to = add_query_arg(
				array(
					'write_downloads' => true,
				),
				$redirect_to
			);
			return $redirect_to;
		}
		if ( 'isfw_download_packing_slip' === $action ) {
			foreach ( $post_ids as $order_id ) {
				$file_path = $this->isfw_generating_pdf( $order_id, 'packing_slip', 'download_on_server' );
				$zip->addFile( $file_path, str_replace( $upload_dir['basedir'], '', $file_path ) );
			}
			@$zip->close(); // phpcs:ignore
			$redirect_to = add_query_arg(
				array(
					'write_downloads' => true,
				),
				$redirect_to
			);
			return $redirect_to;
		}
		return $redirect_to;
	}
	/**
	 * Displaying admin notices for the selected bulk action.
	 *
	 * @return void
	 */
	public function isfw_pdf_downloads_bulk_action_admin_notice() {
		if ( empty( $_REQUEST['write_downloads'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			return;  // Exit.
		}
		$upload_dir     = wp_upload_dir();
		$upload_baseurl = $upload_dir['baseurl'] . '/invoices/';
		$file_url       = $upload_baseurl . 'document.zip';
		require_once INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'admin/templates/invoice-system-for-woocommerce-admin-download-zip-button.php';
	}
}
