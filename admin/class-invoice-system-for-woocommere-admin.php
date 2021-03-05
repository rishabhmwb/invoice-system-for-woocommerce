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
	}

	/**
	 * Adding settings menu for invoice-system-for-woocommere.
	 *
	 * @since    1.0.0
	 */
	public function isfw_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( __( 'MakeWebBetter', 'invoice-system-for-woocommere' ), __( 'MakeWebBetter', 'invoice-system-for-woocommere' ), 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL . 'admin/src/images/mwb-logo.png', 15 );
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
			'name'            => __( 'invoice-system-for-woocommere', 'invoice-system-for-woocommere' ),
			'slug'            => 'invoice_system_for_woocommere_menu',
			'menu_link'       => 'invoice_system_for_woocommere_menu',
			'instance'        => $this,
			'function'        => 'isfw_options_menu_html',
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
	* invoice-system-for-woocommere save tab settings.
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
				}else{
					$mwb_isfw_error_text = esc_html__( 'Settings saved !', 'invoice-system-for-woocommere' );
					$isfw_mwb_isfw_obj->mwb_isfw_plug_admin_notice( $mwb_isfw_error_text, 'success' );
				}
			}
		}
	}
}
