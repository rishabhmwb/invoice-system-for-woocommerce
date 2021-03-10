<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Invoice_system_for_woocommere
 * @subpackage Invoice_system_for_woocommere/admin
 */

use Dompdf\Dompdf;
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Invoice_system_for_woocommere
 * @subpackage Invoice_system_for_woocommere/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Invoice_system_for_woocommere_Admin {

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
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function isfw_admin_enqueue_styles( $hook ) {
		$screen = get_current_screen();
		if ( isset( $screen->id ) && 'makewebbetter_page_invoice_system_for_woocommere_menu' == $screen->id ) {

			wp_enqueue_style( 'mwb-isfw-select2-css', INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'package/lib/select-2/invoice-system-for-woocommere-select2.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-isfw-meterial-css', INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'package/lib/material-design/material-components-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-isfw-meterial-css2', INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-isfw-meterial-lite', INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'package/lib/material-design/material-lite.min.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-isfw-meterial-icons-css', INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'package/lib/material-design/icon.css', array(), time(), 'all' );

			wp_enqueue_style( $this->plugin_name . '-admin-global', INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'admin/src/scss/invoice-system-for-woocommere-admin-global.css', array( 'mwb-isfw-meterial-icons-css' ), time(), 'all' );

			wp_enqueue_style( $this->plugin_name, INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'admin/src/scss/invoice-system-for-woocommere-admin.scss', array(), $this->version, 'all' );
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
		if ( isset( $screen->id ) && 'makewebbetter_page_invoice_system_for_woocommere_menu' == $screen->id ) {
			wp_enqueue_script( 'mwb-isfw-select2', INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'package/lib/select-2/invoice-system-for-woocommere-select2.js', array( 'jquery' ), time(), false );

			wp_enqueue_script( 'mwb-isfw-metarial-js', INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'package/lib/material-design/material-components-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-isfw-metarial-js2', INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-isfw-metarial-lite', INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'package/lib/material-design/material-lite.min.js', array(), time(), false );

			wp_register_script( $this->plugin_name . 'admin-js', INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'admin/src/js/invoice-system-for-woocommere-admin.js', array( 'jquery', 'mwb-isfw-select2', 'mwb-isfw-metarial-js', 'mwb-isfw-metarial-js2', 'mwb-isfw-metarial-lite' ), $this->version, false );

			wp_localize_script(
				$this->plugin_name . 'admin-js',
				'isfw_admin_param',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'reloadurl' => admin_url( 'admin.php?page=invoice_system_for_woocommere_menu' ),
					'isfw_gen_tab_enable' => get_option( 'isfw_radio_switch_demo' ),
				)
			);

			wp_enqueue_script( $this->plugin_name . 'admin-js' );
		}
		wp_enqueue_script( 'mwb-isfw-pdf-general-settings', INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'admin/src/js/invoice-system-for-woocommerce-admin-pdfsettings.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_media();
		wp_localize_script(
			'mwb-isfw-pdf-general-settings',
			'isfw_general_settings',
			array(
				'ajaxurl'                 => admin_url( 'admin-ajax.php' ),
				'isfw_setting_page_nonce' => wp_create_nonce( 'isfw_general_setting_nonce' ),
			)
		);
	}

	/**
	 * Adding settings menu for invoice-system-for-woocommere.
	 *
	 * @since    1.0.0
	 */
	public function isfw_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( 'MakeWebBetter', 'MakeWebBetter', 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'admin/src/images/mwb-logo.png', 15 );
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
	 * invoice-system-for-woocommere isfw_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function isfw_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'      => __( 'invoice-system-for-woocommere', 'invoice-system-for-woocommere' ),
			'slug'      => 'invoice_system_for_woocommere_menu',
			'menu_link' => 'invoice_system_for_woocommere_menu',
			'instance'  => $this,
			'function'  => 'isfw_options_menu_html',
		);
		return $menus;
	}


	/**
	 * invoice-system-for-woocommere mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			require INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * invoice-system-for-woocommere admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function isfw_options_menu_html() {

		include_once INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_PATH . 'admin/partials/invoice-system-for-woocommere-admin-dashboard.php';
	}


	/**
	 * invoice-system-for-woocommere admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $isfw_settings_general Settings fields.
	 */
	public function isfw_admin_general_settings_page( $isfw_settings_general ) {

		$isfw_settings_general = array(
			array(
				'title' => __( 'Enable plugin', 'invoice-system-for-woocommere' ),
				'type'  => 'radio-switch',
				'description'  => __( 'Enable plugin to start the functionality.', 'invoice-system-for-woocommere' ),
				'id'    => 'isfw_radio_switch_demo',
				'value' => get_option( 'isfw_radio_switch_demo' ),
				'class' => 'isfw-radio-switch-class',
				'options' => array(
					'yes' => __( 'YES', 'invoice-system-for-woocommere' ),
					'no' => __( 'NO', 'invoice-system-for-woocommere' ),
				),
			),

			array(
				'type'  => 'button',
				'id'    => 'isfw_button_demo',
				'button_text' => __( 'Button Demo', 'invoice-system-for-woocommere' ),
				'class' => 'isfw-button-class',
			),
		);
		// print_r($isfw_settings_general);die;
		return $isfw_settings_general;
	}

	/**
	 * invoice-system-for-woocommere admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $isfw_settings_template Settings fields.
	 */
	public function isfw_admin_template_settings_page( $isfw_settings_template ) {
		$isfw_settings_template = array(
			array(
				'title' => __( 'Text Field Demo', 'invoice-system-for-woocommere' ),
				'type'  => 'text',
				'description'  => __( 'This is text field demo follow same structure for further use.', 'invoice-system-for-woocommere' ),
				'id'    => 'isfw_text_demo',
				'value' => '',
				'class' => 'isfw-text-class',
				'placeholder' => __( 'Text Demo', 'invoice-system-for-woocommere' ),
			),
			array(
				'title' => __( 'Number Field Demo', 'invoice-system-for-woocommere' ),
				'type'  => 'number',
				'description'  => __( 'This is number field demo follow same structure for further use.', 'invoice-system-for-woocommere' ),
				'id'    => 'isfw_number_demo',
				'value' => '',
				'class' => 'isfw-number-class',
				'placeholder' => '',
			),
			array(
				'title' => __( 'Password Field Demo', 'invoice-system-for-woocommere' ),
				'type'  => 'password',
				'description'  => __( 'This is password field demo follow same structure for further use.', 'invoice-system-for-woocommere' ),
				'id'    => 'isfw_password_demo',
				'value' => '',
				'class' => 'isfw-password-class',
				'placeholder' => '',
			),
			array(
				'title' => __( 'Textarea Field Demo', 'invoice-system-for-woocommere' ),
				'type'  => 'textarea',
				'description'  => __( 'This is textarea field demo follow same structure for further use.', 'invoice-system-for-woocommere' ),
				'id'    => 'isfw_textarea_demo',
				'value' => '',
				'class' => 'isfw-textarea-class',
				'rows' => '5',
				'cols' => '10',
				'placeholder' => __( 'Textarea Demo', 'invoice-system-for-woocommere' ),
			),
			array(
				'title' => __( 'Select Field Demo', 'invoice-system-for-woocommere' ),
				'type'  => 'select',
				'description'  => __( 'This is select field demo follow same structure for further use.', 'invoice-system-for-woocommere' ),
				'id'    => 'isfw_select_demo',
				'value' => '',
				'class' => 'isfw-select-class',
				'placeholder' => __( 'Select Demo', 'invoice-system-for-woocommere' ),
				'options' => array(
					'' => __( 'Select option', 'invoice-system-for-woocommere' ),
					'INR' => __( 'Rs.', 'invoice-system-for-woocommere' ),
					'USD' => __( '$', 'invoice-system-for-woocommere' ),
				),
			),
			array(
				'title' => __( 'Multiselect Field Demo', 'invoice-system-for-woocommere' ),
				'type'  => 'multiselect',
				'description'  => __( 'This is multiselect field demo follow same structure for further use.', 'invoice-system-for-woocommere' ),
				'id'    => 'isfw_multiselect_demo',
				'value' => '',
				'class' => 'isfw-multiselect-class mwb-defaut-multiselect',
				'placeholder' => '',
				'options' => array(
					'default' => __( 'Select currency code from options', 'invoice-system-for-woocommere' ),
					'INR' => __( 'Rs.', 'invoice-system-for-woocommere' ),
					'USD' => __( '$', 'invoice-system-for-woocommere' ),
				),
			),
			array(
				'title' => __( 'Checkbox Field Demo', 'invoice-system-for-woocommere' ),
				'type'  => 'checkbox',
				'description'  => __( 'This is checkbox field demo follow same structure for further use.', 'invoice-system-for-woocommere' ),
				'id'    => 'isfw_checkbox_demo',
				'value' => '',
				'class' => 'isfw-checkbox-class',
				'placeholder' => __( 'Checkbox Demo', 'invoice-system-for-woocommere' ),
			),

			array(
				'title' => __( 'Radio Field Demo', 'invoice-system-for-woocommere' ),
				'type'  => 'radio',
				'description'  => __( 'This is radio field demo follow same structure for further use.', 'invoice-system-for-woocommere' ),
				'id'    => 'isfw_radio_demo',
				'value' => '',
				'class' => 'isfw-radio-class',
				'placeholder' => __( 'Radio Demo', 'invoice-system-for-woocommere' ),
				'options' => array(
					'yes' => __( 'YES', 'invoice-system-for-woocommere' ),
					'no' => __( 'NO', 'invoice-system-for-woocommere' ),
				),
			),
			array(
				'title' => __( 'Enable', 'invoice-system-for-woocommere' ),
				'type'  => 'radio-switch',
				'description'  => __( 'This is switch field demo follow same structure for further use.', 'invoice-system-for-woocommere' ),
				'id'    => 'isfw_radio_switch_demo',
				'value' => '',
				'class' => 'isfw-radio-switch-class',
				'options' => array(
					'yes' => __( 'YES', 'invoice-system-for-woocommere' ),
					'no' => __( 'NO', 'invoice-system-for-woocommere' ),
				),
			),
			array(
				'type'  => 'button',
				'id'    => 'isfw_button_demo',
				'button_text' => __( 'Button Demo', 'invoice-system-for-woocommere' ),
				'class' => 'isfw-button-class',
			),
		);
		return $isfw_settings_template;
	}


	/**
	 * invoice-system-for-woocommere support page tabs.
	 *
	 * @since    1.0.0
	 * @param    Array $mwb_isfw_support Settings fields.
	 * @return   Array  $mwb_isfw_support
	 */
	public function isfw_admin_support_settings_page( $mwb_isfw_support ) {
		$mwb_isfw_support = array(
			array(
				'title' => __( 'User Guide', 'invoice-system-for-woocommere' ),
				'description' => __( 'View the detailed guides and documentation to set up your plugin.', 'invoice-system-for-woocommere' ),
				'link-text' => __( 'VIEW', 'invoice-system-for-woocommere' ),
				'link' => '',
			),
			array(
				'title' => __( 'Free Support', 'invoice-system-for-woocommere' ),
				'description' => __( 'Please submit a ticket , our team will respond within 24 hours.', 'invoice-system-for-woocommere' ),
				'link-text' => __( 'SUBMIT', 'invoice-system-for-woocommere' ),
				'link' => '',
			),
		);

		return apply_filters( 'mwb_isfw_add_support_content', $mwb_isfw_support );
	}
	/**
	* Invoice-system-for-woocommere save tab settings.
	*
	* @since 1.0.0
	*/
	public function isfw_admin_save_tab_settings() {
		global $isfw_mwb_isfw_obj;
		if ( isset( $_POST['isfw_button_demo'] ) ) {
			$mwb_isfw_gen_flag = false;
			$isfw_genaral_settings = apply_filters( 'isfw_general_settings_array', array() );
			$isfw_button_index = array_search( 'submit', array_column( $isfw_genaral_settings, 'type' ) );
			if ( isset( $isfw_button_index ) && ( null == $isfw_button_index || '' == $isfw_button_index ) ) {
				$isfw_button_index = array_search( 'button', array_column( $isfw_genaral_settings, 'type' ) );
			}
			if ( isset( $isfw_button_index ) && '' !== $isfw_button_index ) {
				unset( $isfw_genaral_settings[$isfw_button_index] );
				if ( is_array( $isfw_genaral_settings ) && ! empty( $isfw_genaral_settings ) ) {
					foreach ( $isfw_genaral_settings as $isfw_genaral_setting ) {
						if ( isset( $isfw_genaral_setting['id'] ) && '' !== $isfw_genaral_setting['id'] ) {
							if ( isset( $_POST[$isfw_genaral_setting['id']] ) ) {
								update_option( $isfw_genaral_setting['id'], $_POST[$isfw_genaral_setting['id']] );
							} else {
								update_option( $isfw_genaral_setting['id'], '' );
							}
						}else{
							$mwb_isfw_gen_flag = true;
						}
					}
				}
				if ( $mwb_isfw_gen_flag ) {
					$mwb_isfw_error_text = esc_html__( 'Id of some field is missing', 'invoice-system-for-woocommere' );
					$isfw_mwb_isfw_obj->mwb_isfw_plug_admin_notice( $mwb_isfw_error_text, 'error' );
				} else {
					$mwb_isfw_error_text = esc_html__( 'Settings saved !', 'invoice-system-for-woocommere' );
					$isfw_mwb_isfw_obj->mwb_isfw_plug_admin_notice( $mwb_isfw_error_text, 'success' );
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
		$isfw_pdf_settings = get_option( 'mwb_isfw_pdf_general_settings' );
		if ( $isfw_pdf_settings ) {
			$prefix       = array_key_exists( 'prefix', $isfw_pdf_settings ) ? $isfw_pdf_settings['prefix'] : '';
			$suffix       = array_key_exists( 'suffix', $isfw_pdf_settings ) ? $isfw_pdf_settings['suffix'] : '';
			$digit        = array_key_exists( 'digit', $isfw_pdf_settings ) ? $isfw_pdf_settings['digit'] : '';
			$logo         = array_key_exists( 'logo', $isfw_pdf_settings ) ? $isfw_pdf_settings['logo'] : '';
			$date         = array_key_exists( 'date', $isfw_pdf_settings ) ? $isfw_pdf_settings['date'] : '';
			$disclaimer   = array_key_exists( 'disclaimer', $isfw_pdf_settings ) ? $isfw_pdf_settings['disclaimer'] : '';
			$color        = array_key_exists( 'color', $isfw_pdf_settings ) ? $isfw_pdf_settings['color'] : '';
			$order_status = array_key_exists( 'order_status', $isfw_pdf_settings ) ? $isfw_pdf_settings['order_status'] : array();
		} else {
			$prefix       = '';
			$suffix       = '';
			$digit        = '';
			$date         = date( 'Y-m-d' );
			$disclaimer   = '';
			$color        = '#000000';
			$logo         = '';
			$order_status = array();
		}
		$order_statuses             = wc_get_order_statuses();
		$isfw_template_pdf_settings = array(
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
						'placeholder' => 'Prefix',
					),
					array(
						'title'       => __( 'Digit', 'invoice-system-for-woocommerce' ),
						'type'        => 'number',
						'id'          => 'isfw_invoice_number_digit',
						'class'       => 'isfw_invoice_number_digit',
						'value'       => $digit,
						'name'        => 'isfw_invoice_number_digit',
						'placeholder' => 'digit',
					),
					array(
						'title'       => __( 'Suffix', 'invoice-system-for-woocommerce' ),
						'type'        => 'text',
						'id'          => 'isfw_invoice_number_suffix',
						'class'       => 'isfw_invoice_number_suffix',
						'value'       => $suffix,
						'name'        => 'isfw_invoice_number_suffix',
						'placeholder' => 'suffix',
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
				'title'       => __( 'Send invoice for', 'invoice-system-for-woocommere' ),
				'type'        => 'select',
				'description' => __( 'Please choose the status of orders to send invoice for.', 'invoice-system-for-woocommere' ),
				'id'          => 'isfw_send_invoice_for',
				'value'       => $order_status,
				'class'       => 'isfw-select-class',
				'placeholder' => '',
				'options'     => $order_statuses,
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
		$settings_data = array_key_exists( 'settings_data', $_POST ) ? $_POST['settings_data'] : '';
		if ( update_option( 'mwb_isfw_pdf_general_settings', $settings_data ) ) {
			esc_html_e( 'updated successfully', 'invoice-system-for-woocommere' );
		} else {
			esc_html_e( 'there might be some error', 'invoice-system-for-woocommere' );
		}
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
			$order_items    = $order->get_items();
			$order_item_arr = array();
			$_tax           = new WC_Tax();
			$i              = 0;
			foreach ( $order_items as $orders ) {
				$order_data                          = $orders->get_data();
				$order_item_arr[ $i ]['prod_id']     = $order_data['product_id'];
				$order_item_arr[ $i ]['prod_name']   = $order_data['name'];
				$order_item_arr[ $i ]['quantity']    = $order_data['quantity'];
				$order_item_arr[ $i ]['sub_total']   = $order_data['total'];
				$order_item_arr[ $i ]['total']       = preg_replace( '/,/', '.', $order_data['total'] ) + preg_replace( '/,/', '.', $order_data['total_tax'] );
				$order_item_arr[ $i ]['percent_tax'] = $_tax->get_rates( $orders->get_tax_class() );
				$i++;
			}
			$order_shipping_arr                        = array();
			$order_shipping_arr['shipping_method']     = $order->get_shipping_method();
			$order_shipping_arr['shipping_full_name']  = $order->get_formatted_shipping_full_name();
			$order_shipping_arr['shipping_method']     = $order->get_shipping_method();
			$order_shipping_arr['shipping_address_1']  = $order->get_shipping_address_1();
			$order_shipping_arr['shipping_address_2']  = $order->get_shipping_address_2();
			$order_shipping_arr['shipping_city']       = $order->get_shipping_city();
			$order_shipping_arr['shipping_state']      = $order->get_shipping_state();
			$order_shipping_arr['shipping_postcode']   = $order->get_shipping_postcode();
			$order_shipping_arr['shipping_country']    = $order->get_shipping_country();
			$order_shipping_arr['shipping_postcode']   = $order->get_shipping_postcode();
			$order_shipping_arr['shipping_total']      = $order->get_shipping_total();
			$order_billing_arr                         = array();
			$order_billing_arr['billing_full_name']    = $order->get_formatted_billing_full_name();
			$order_billing_arr['billing_address_1']    = $order->get_billing_address_1();
			$order_billing_arr['billing_address_2']    = $order->get_billing_address_2();
			$order_billing_arr['billing_city']         = $order->get_billing_city();
			$order_billing_arr['billing_state']        = $order->get_billing_state();
			$order_billing_arr['billing_postcode']     = $order->get_billing_postcode();
			$order_billing_arr['billing_country']      = $order->get_billing_country();
			$order_billing_arr['billing_email']        = $order->get_billing_email();
			$order_billing_arr['billing_phone']        = $order->get_billing_phone();
			$order_payment_arr                         = array();
			$order_payment_arr['payment_method']       = $order->get_payment_method();
			$order_payment_arr['payment_method_title'] = $order->get_payment_method_title();
			$order_payment_arr['transaction_id']       = $order->get_transaction_id();
			$order_payment_arr['order_created']        = $order->get_date_created();
			$order_payment_arr['order_completed_date'] = $order->get_date_completed();
			$order_payment_arr['payment_date']         = $order->get_date_paid();
			$order_payment_arr['order_currency']       = get_woocommerce_currency_symbol();
			$order_payment_arr['order_total']          = $order->get_total();
			$order_payment_arr['tax_total']            = $order->get_tax_totals();
			$order_payment_arr['sub_total']            = $order->get_subtotal();
			$order_details_arr                         = array(
				'order_items'    => $order_item_arr,
				'order_shipping' => $order_shipping_arr,
				'order_billing'  => $order_billing_arr,
				'order_payment'  => $order_payment_arr,
			);
			return wp_json_encode( $order_details_arr );
		}
		return 'not found';
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
			_e( '<div><span style="margin-left:20px;"><a href="/wp-admin/post.php?orderid='. $post->ID . '&action=generateinvoice" style="margin-left:5px;" id="isfw-print-invoice-order-listing-page" data-order-id="' . $post->ID . '"><img src="' . INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'admin/src/images/invoice_pdf.svg" width="20" height="20" title="'. __( "Generate invoice", "invoice-system-for-woocommerce" ) .'"></a><a href="/wp-admin/post.php?orderid='. $post->ID . '&action=generateslip" style="margin-left:5px;" id="isfw-print-invoice-order-listing-page" data-order-id="' . $post->ID . '"><img src="' . INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'admin/src/images/packing_slip.svg" width="20" height="20" title="' . __( "Generate packing slip", "invoice-system-for-woocommerce"  ) . '"></a></span></div>' );
		}
	}
	/**
	 * Creating pdf by passing order id.
	 *
	 * @return void
	 */
	public function isfw_create_pdf() {
		global $pagenow;
		if ( $pagenow == 'post.php' ) {
			if ( isset( $_GET['orderid'] ) && isset( $_GET['action'] ) ) {
				if ( $_GET['action'] == 'generateinvoice' ) {
					$order_id = $_GET['orderid'];
					$this->isfw_generating_pdf( $order_id, 'invoice', 'download_locally' );
				}
				if ( $_GET['action'] == 'generateslip' ) {
					$order_id = $_GET['orderid'];
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
		require_once INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_PATH . 'package/lib/dompdf/vendor/autoload.php';
		// require_once INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_PATH . 'admin/partials/templates/invoice-system-for-woocommerce-pdflayout1.php';
		require_once INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_PATH . 'admin/partials/templates/invoice-system-for-woocommerce-pdflayout2.php';
		$html   = (string) return_ob_value( $order_id, $type );
		$dompdf = new Dompdf();
		$dompdf->loadHtml( $html );
		$dompdf->setPaper( 'A4' );
		ob_end_clean();
		$dompdf->render();
		if ( 'download_locally' === $action ) {
			$dompdf->stream( $type . '_' . $order_id . '.pdf', array( 'Attachment' => 1 ) );
		}
		if ( 'open_window' === $action ) {
			$dompdf->stream( $type . '_' . $order_id . '.pdf', array( 'Attachment' => 0 ) );
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
					if ( file_exists( $file ) ) {
						$attachments[] = $file;
					}
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
		if ( empty( $_REQUEST['write_downloads'] ) ) return; // Exit.
		$processed_count = $_REQUEST['processed_count'];
		add_thickbox();
		?>
		<div class="updated">
		<div><?php esc_html_e( 'Files has been processed and are ready to donload in zip.', 'invoice-system-for-woocommerce' ); ?></div>
		<a href="#TB_inline?width=100&height=100&inlineId=modal-window-id" class="thickbox"><?php esc_html_e( 'Click here to open panel to download', 'invoice-system-for-woocommerce' ); ?></a>
			<div id="modal-window-id" style="display:none;">
			<?php
				$upload_dir     = wp_upload_dir();
				$upload_baseurl = $upload_dir['baseurl'] . '/invoices/';
				$file_url       = $upload_baseurl . 'document.zip';
			?>
				<div>
					<?php printf( _n( '%s file has been processed', '%s files has been procesed', $processed_count, 'invoice-system-for-woocommerce' ), $processed_count ); ?>
					<a href='<?php echo esc_attr( $file_url ); ?>'><?php esc_html_e( 'Download zip', 'invoice-system-for-woocommerce' ); ?></a>
				</div>
			</div>
		</div>
		<script type='text/javascript'>
			jQuery(document).ready(function($){
				setTimeout(function(){
					$(document).find('a.thickbox').trigger('click');
				}, 2000);
			});
		</script>
		<?php
		// $file_url = INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL .'invoices/document.zip';
		// header( 'Content-Description: File Transfer' );
		// header('Content-Type: application/octet-stream' );
		// header( 'Content-Disposition: attachment; filename='.basename( $file_url ) );
		// header( 'Content-Transfer-Encoding: binary' );
		// header( 'Expires: 0');
		// header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		// header( 'Pragma: public' );
		// header( 'Content-Length: ' . filesize( $file_url ));
		// ob_clean();
		// flush();
		// readfile( $file_url );
	}
}
