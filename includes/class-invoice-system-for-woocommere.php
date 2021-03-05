<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Invoice_system_for_woocommere
 * @subpackage Invoice_system_for_woocommere/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Invoice_system_for_woocommere
 * @subpackage Invoice_system_for_woocommere/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Invoice_system_for_woocommere {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Invoice_system_for_woocommere_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $isfw_onboard    To initializsed the object of class onboard.
	 */
	protected $isfw_onboard;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'INVOICE_SYSTEM_FOR_WOOCOMMERE_VERSION' ) ) {

			$this->version = INVOICE_SYSTEM_FOR_WOOCOMMERE_VERSION;
		} else {

			$this->version = '1.0.0';
		}

		$this->plugin_name = 'invoice-system-for-woocommere';

		$this->invoice_system_for_woocommere_dependencies();
		$this->invoice_system_for_woocommere_locale();
		if ( is_admin() ) {
			$this->invoice_system_for_woocommere_admin_hooks();
		} else {
			$this->invoice_system_for_woocommere_public_hooks();
		}

		$this->invoice_system_for_woocommere_api_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Invoice_system_for_woocommere_Loader. Orchestrates the hooks of the plugin.
	 * - Invoice_system_for_woocommere_i18n. Defines internationalization functionality.
	 * - Invoice_system_for_woocommere_Admin. Defines all hooks for the admin area.
	 * - Invoice_system_for_woocommere_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function invoice_system_for_woocommere_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-invoice-system-for-woocommere-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-invoice-system-for-woocommere-i18n.php';

		if ( is_admin() ) {

			// The class responsible for defining all actions that occur in the admin area.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-invoice-system-for-woocommere-admin.php';

			// The class responsible for on-boarding steps for plugin.
			if ( is_dir(  plugin_dir_path( dirname( __FILE__ ) ) . '.onboarding' ) && ! class_exists( 'Invoice_system_for_woocommere_Onboarding_Steps' ) ) {
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-invoice-system-for-woocommere-onboarding-steps.php';
			}

			if ( class_exists( 'Invoice_system_for_woocommere_Onboarding_Steps' ) ) {
				$isfw_onboard_steps = new Invoice_system_for_woocommere_Onboarding_Steps();
			}
		} else {

			// The class responsible for defining all actions that occur in the public-facing side of the site.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-invoice-system-for-woocommere-public.php';

		}

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'package/rest-api/class-invoice-system-for-woocommere-rest-api.php';

		$this->loader = new Invoice_system_for_woocommere_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Invoice_system_for_woocommere_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function invoice_system_for_woocommere_locale() {

		$plugin_i18n = new Invoice_system_for_woocommere_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function invoice_system_for_woocommere_admin_hooks() {

		$isfw_plugin_admin = new Invoice_system_for_woocommere_Admin( $this->isfw_get_plugin_name(), $this->isfw_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $isfw_plugin_admin, 'isfw_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $isfw_plugin_admin, 'isfw_admin_enqueue_scripts' );

		// Add settings menu for invoice-system-for-woocommere.
		$this->loader->add_action( 'admin_menu', $isfw_plugin_admin, 'isfw_options_page' );
		$this->loader->add_action( 'admin_menu', $isfw_plugin_admin, 'mwb_isfw_remove_default_submenu', 50 );

		// All admin actions and filters after License Validation goes here.
		$this->loader->add_filter( 'mwb_add_plugins_menus_array', $isfw_plugin_admin, 'isfw_admin_submenu_page', 15 );
		$this->loader->add_filter( 'isfw_template_settings_array', $isfw_plugin_admin, 'isfw_admin_template_settings_page', 10 );
		$this->loader->add_filter( 'isfw_general_settings_array', $isfw_plugin_admin, 'isfw_admin_general_settings_page', 10 );
		$this->loader->add_filter( 'isfw_supprot_tab_settings_array', $isfw_plugin_admin, 'isfw_admin_support_settings_page', 10 );

		// Saving tab settings.
		$this->loader->add_action( 'admin_init', $isfw_plugin_admin, 'isfw_admin_save_tab_settings' );
		$this->loader->add_filter( 'isfw_template_pdf_settings_array', $isfw_plugin_admin, 'isfw_template_pdf_settings_page', 10 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function invoice_system_for_woocommere_public_hooks() {

		$isfw_plugin_public = new Invoice_system_for_woocommere_Public( $this->isfw_get_plugin_name(), $this->isfw_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $isfw_plugin_public, 'isfw_public_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $isfw_plugin_public, 'isfw_public_enqueue_scripts' );

	}


	/**
	 * Register all of the hooks related to the api functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function invoice_system_for_woocommere_api_hooks() {

		$isfw_plugin_api = new Invoice_system_for_woocommere_Rest_Api( $this->isfw_get_plugin_name(), $this->isfw_get_version() );

		$this->loader->add_action( 'rest_api_init', $isfw_plugin_api, 'mwb_isfw_add_endpoint' );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function isfw_run() {
		$this->loader->isfw_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function isfw_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Invoice_system_for_woocommere_Loader    Orchestrates the hooks of the plugin.
	 */
	public function isfw_get_loader() {
		return $this->loader;
	}


	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Invoice_system_for_woocommere_Onboard    Orchestrates the hooks of the plugin.
	 */
	public function isfw_get_onboard() {
		return $this->isfw_onboard;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function isfw_get_version() {
		return $this->version;
	}

	/**
	 * Predefined default mwb_isfw_plug tabs.
	 *
	 * @return  Array       An key=>value pair of invoice-system-for-woocommere tabs.
	 */
	public function mwb_isfw_plug_default_tabs() {

		$isfw_default_tabs = array();

		$isfw_default_tabs['invoice-system-for-woocommere-general'] = array(
			'title'       => esc_html__( 'General Setting', 'invoice-system-for-woocommere' ),
			'name'        => 'invoice-system-for-woocommere-general',
		);
		$isfw_default_tabs = apply_filters( 'mwb_isfw_plugin_standard_admin_settings_tabs', $isfw_default_tabs );

		$isfw_default_tabs['invoice-system-for-woocommere-system-status'] = array(
			'title'       => esc_html__( 'System Status', 'invoice-system-for-woocommere' ),
			'name'        => 'invoice-system-for-woocommere-system-status',
		);
		$isfw_default_tabs['invoice-system-for-woocommere-template'] = array(
			'title'       => esc_html__( 'Templates', 'invoice-system-for-woocommere' ),
			'name'        => 'invoice-system-for-woocommere-template',
		);

		return $isfw_default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since   1.0.0
	 * @param string $path path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function mwb_isfw_plug_load_template( $path, $params = array() ) {

		$isfw_file_path = INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_PATH . $path;

		if ( file_exists( $isfw_file_path ) ) {

			include $isfw_file_path;
		} else {

			/* translators: %s: file path */
			$isfw_notice = sprintf( esc_html__( 'Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'invoice-system-for-woocommere' ), $isfw_file_path );
			$this->mwb_isfw_plug_admin_notice( $isfw_notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param  string $isfw_message    Message to display.
	 * @param  string $type       notice type, accepted values - error/update/update-nag.
	 * @since  1.0.0
	 */
	public static function mwb_isfw_plug_admin_notice( $isfw_message, $type = 'error' ) {

		$isfw_classes = 'notice ';

		switch ( $type ) {

			case 'update':
			$isfw_classes .= 'updated is-dismissible';
			break;

			case 'update-nag':
			$isfw_classes .= 'update-nag is-dismissible';
			break;

			case 'success':
			$isfw_classes .= 'notice-success is-dismissible';
			break;

			default:
			$isfw_classes .= 'notice-error is-dismissible';
		}

		$isfw_notice  = '<div class="' . esc_attr( $isfw_classes ) . ' mwb-errorr-8">';
		$isfw_notice .= '<p>' . esc_html( $isfw_message ) . '</p>';
		$isfw_notice .= '</div>';

		echo wp_kses_post( $isfw_notice );
	}


	/**
	 * Show wordpress and server info.
	 *
	 * @return  Array $isfw_system_data       returns array of all wordpress and server related information.
	 * @since  1.0.0
	 */
	public function mwb_isfw_plug_system_status() {
		global $wpdb;
		$isfw_system_status = array();
		$isfw_wordpress_status = array();
		$isfw_system_data = array();

		// Get the web server.
		$isfw_system_status['web_server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

		// Get PHP version.
		$isfw_system_status['php_version'] = function_exists( 'phpversion' ) ? phpversion() : __( 'N/A (phpversion function does not exist)', 'invoice-system-for-woocommere' );

		// Get the server's IP address.
		$isfw_system_status['server_ip'] = isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '';

		// Get the server's port.
		$isfw_system_status['server_port'] = isset( $_SERVER['SERVER_PORT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) : '';

		// Get the uptime.
		$isfw_system_status['uptime'] = function_exists( 'exec' ) ? @exec( 'uptime -p' ) : __( 'N/A (make sure exec function is enabled)', 'invoice-system-for-woocommere' );

		// Get the server path.
		$isfw_system_status['server_path'] = defined( 'ABSPATH' ) ? ABSPATH : __( 'N/A (ABSPATH constant not defined)', 'invoice-system-for-woocommere' );

		// Get the OS.
		$isfw_system_status['os'] = function_exists( 'php_uname' ) ? php_uname( 's' ) : __( 'N/A (php_uname function does not exist)', 'invoice-system-for-woocommere' );

		// Get WordPress version.
		$isfw_wordpress_status['wp_version'] = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'version' ) : __( 'N/A (get_bloginfo function does not exist)', 'invoice-system-for-woocommere' );

		// Get and count active WordPress plugins.
		$isfw_wordpress_status['wp_active_plugins'] = function_exists( 'get_option' ) ? count( get_option( 'active_plugins' ) ) : __( 'N/A (get_option function does not exist)', 'invoice-system-for-woocommere' );

		// See if this site is multisite or not.
		$isfw_wordpress_status['wp_multisite'] = function_exists( 'is_multisite' ) && is_multisite() ? __( 'Yes', 'invoice-system-for-woocommere' ) : __( 'No', 'invoice-system-for-woocommere' );

		// See if WP Debug is enabled.
		$isfw_wordpress_status['wp_debug_enabled'] = defined( 'WP_DEBUG' ) ? __( 'Yes', 'invoice-system-for-woocommere' ) : __( 'No', 'invoice-system-for-woocommere' );

		// See if WP Cache is enabled.
		$isfw_wordpress_status['wp_cache_enabled'] = defined( 'WP_CACHE' ) ? __( 'Yes', 'invoice-system-for-woocommere' ) : __( 'No', 'invoice-system-for-woocommere' );

		// Get the total number of WordPress users on the site.
		$isfw_wordpress_status['wp_users'] = function_exists( 'count_users' ) ? count_users() : __( 'N/A (count_users function does not exist)', 'invoice-system-for-woocommere' );

		// Get the number of published WordPress posts.
		$isfw_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : __( '0', 'invoice-system-for-woocommere' );

		// Get PHP memory limit.
		$isfw_system_status['php_memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'invoice-system-for-woocommere' );

		// Get the PHP error log path.
		$isfw_system_status['php_error_log_path'] = ! ini_get( 'error_log' ) ? __( 'N/A', 'invoice-system-for-woocommere' ) : ini_get( 'error_log' );

		// Get PHP max upload size.
		$isfw_system_status['php_max_upload'] = function_exists( 'ini_get' ) ? (int) ini_get( 'upload_max_filesize' ) : __( 'N/A (ini_get function does not exist)', 'invoice-system-for-woocommere' );

		// Get PHP max post size.
		$isfw_system_status['php_max_post'] = function_exists( 'ini_get' ) ? (int) ini_get( 'post_max_size' ) : __( 'N/A (ini_get function does not exist)', 'invoice-system-for-woocommere' );

		// Get the PHP architecture.
		if ( PHP_INT_SIZE == 4 ) {
			$isfw_system_status['php_architecture'] = '32-bit';
		} elseif ( PHP_INT_SIZE == 8 ) {
			$isfw_system_status['php_architecture'] = '64-bit';
		} else {
			$isfw_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$isfw_system_status['server_hostname'] = function_exists( 'gethostname' ) ? gethostname() : __( 'N/A (gethostname function does not exist)', 'invoice-system-for-woocommere' );

		// Show the number of processes currently running on the server.
		$isfw_system_status['processes'] = function_exists( 'exec' ) ? @exec( 'ps aux | wc -l' ) : __( 'N/A (make sure exec is enabled)', 'invoice-system-for-woocommere' );

		// Get the memory usage.
		$isfw_system_status['memory_usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if ( stristr( PHP_OS, 'win' ) ) {
			$isfw_system_status['is_windows'] = true;
			$isfw_system_status['windows_cpu_usage'] = function_exists( 'exec' ) ? @exec( 'wmic cpu get loadpercentage /all' ) : __( 'N/A (make sure exec is enabled)', 'invoice-system-for-woocommere' );
		}

		// Get the memory limit.
		$isfw_system_status['memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'invoice-system-for-woocommere' );

		// Get the PHP maximum execution time.
		$isfw_system_status['php_max_execution_time'] = function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : __( 'N/A (ini_get function does not exist)', 'invoice-system-for-woocommere' );

		// Get outgoing IP address.
		$isfw_system_status['outgoing_ip'] = function_exists( 'file_get_contents' ) ? file_get_contents( 'http://ipecho.net/plain' ) : __( 'N/A (file_get_contents function does not exist)', 'invoice-system-for-woocommere' );

		$isfw_system_data['php'] = $isfw_system_status;
		$isfw_system_data['wp'] = $isfw_wordpress_status;

		return $isfw_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param  string $isfw_components    html to display.
	 * @since  1.0.0
	 */
	public function mwb_isfw_plug_generate_html( $isfw_components = array() ) {
		if ( is_array( $isfw_components ) && ! empty( $isfw_components ) ) {
			foreach ( $isfw_components as $isfw_component ) {
				switch ( $isfw_component['type'] ) {

					case 'hidden':
					case 'number':
					case 'email':
					case 'text':
					?>
					<div class="mwb-form-group mwb-isfw-<?php echo esc_attr($isfw_component['type']); ?>">
						<div class="mwb-form-group__label">
							<label for="<?php echo esc_attr( $isfw_component['id'] ); ?>" class="mwb-form-label"><?php echo esc_html( $isfw_component['title'] ); // WPCS: XSS ok. ?></label>
						</div>
						<div class="mwb-form-group__control">
							<label class="mdc-text-field mdc-text-field--outlined">
								<span class="mdc-notched-outline">
									<span class="mdc-notched-outline__leading"></span>
									<span class="mdc-notched-outline__notch">
										<?php if ( 'number' != $isfw_component['type'] ) { ?>
											<span class="mdc-floating-label" id="my-label-id" style=""><?php echo esc_attr( $isfw_component['placeholder'] ); ?></span>
										<?php } ?>
									</span>
									<span class="mdc-notched-outline__trailing"></span>
								</span>
								<input 
								class="mdc-text-field__input <?php echo esc_attr( $isfw_component['class'] ); ?>" 
								name="<?php echo esc_attr( $isfw_component['id'] ); ?>"
								id="<?php echo esc_attr( $isfw_component['id'] ); ?>"
								type="<?php echo esc_attr( $isfw_component['type'] ); ?>"
								value="<?php echo esc_attr( $isfw_component['value'] ); ?>"
								placeholder="<?php echo esc_attr( $isfw_component['placeholder'] ); ?>"
								>
							</label>
							<div class="mdc-text-field-helper-line">
								<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo esc_attr( $isfw_component['description'] ); ?></div>
							</div>
						</div>
					</div>
					<?php
					break;

					case 'password':
					?>
					<div class="mwb-form-group">
						<div class="mwb-form-group__label">
							<label for="<?php echo esc_attr( $isfw_component['id'] ); ?>" class="mwb-form-label"><?php echo esc_html( $isfw_component['title'] ); // WPCS: XSS ok. ?></label>
						</div>
						<div class="mwb-form-group__control">
							<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
								<span class="mdc-notched-outline">
									<span class="mdc-notched-outline__leading"></span>
									<span class="mdc-notched-outline__notch">
									</span>
									<span class="mdc-notched-outline__trailing"></span>
								</span>
								<input 
								class="mdc-text-field__input <?php echo esc_attr( $isfw_component['class'] ); ?> mwb-form__password" 
								name="<?php echo esc_attr( $isfw_component['id'] ); ?>"
								id="<?php echo esc_attr( $isfw_component['id'] ); ?>"
								type="<?php echo esc_attr( $isfw_component['type'] ); ?>"
								value="<?php echo esc_attr( $isfw_component['value'] ); ?>"
								placeholder="<?php echo esc_attr( $isfw_component['placeholder'] ); ?>"
								>
								<i class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing mwb-password-hidden" tabindex="0" role="button">visibility</i>
							</label>
							<div class="mdc-text-field-helper-line">
								<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo esc_attr( $isfw_component['description'] ); ?></div>
							</div>
						</div>
					</div>
					<?php
					break;

					case 'textarea':
					?>
					<div class="mwb-form-group">
						<div class="mwb-form-group__label">
							<label class="mwb-form-label" for="<?php echo esc_attr( $isfw_component['id'] ); ?>"><?php echo esc_attr( $isfw_component['title'] ); ?></label>
						</div>
						<div class="mwb-form-group__control">
							<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea"  	for="text-field-hero-input">
								<span class="mdc-notched-outline">
									<span class="mdc-notched-outline__leading"></span>
									<span class="mdc-notched-outline__notch">
										<span class="mdc-floating-label"><?php echo esc_attr( $isfw_component['placeholder'] ); ?></span>
									</span>
									<span class="mdc-notched-outline__trailing"></span>
								</span>
								<span class="mdc-text-field__resizer">
									<textarea class="mdc-text-field__input <?php echo esc_attr( $isfw_component['class'] ); ?>" rows="2" cols="25" aria-label="Label" name="<?php echo esc_attr( $isfw_component['id'] ); ?>" id="<?php echo esc_attr( $isfw_component['id'] ); ?>" placeholder="<?php echo esc_attr( $isfw_component['placeholder'] ); ?>"><?php echo esc_textarea( $isfw_component['value'] ); // WPCS: XSS ok. ?></textarea>
								</span>
							</label>

						</div>
					</div>

					<?php
					break;

					case 'select':
					case 'multiselect':
					?>
					<div class="mwb-form-group">
						<div class="mwb-form-group__label">
							<label class="mwb-form-label" for="<?php echo esc_attr( $isfw_component['id'] ); ?>"><?php echo esc_html( $isfw_component['title'] ); ?></label>
						</div>
						<div class="mwb-form-group__control">
							<div class="mwb-form-select">
								<select name="<?php echo esc_attr( $isfw_component['id'] ); ?><?php echo ( 'multiselect' === $isfw_component['type'] ) ? '[]' : ''; ?>" id="<?php echo esc_attr( $isfw_component['id'] ); ?>" class="mdl-textfield__input <?php echo esc_attr( $isfw_component['class'] ); ?>" <?php echo 'multiselect' === $isfw_component['type'] ? 'multiple="multiple"' : ''; ?> >
									<?php
									foreach ( $isfw_component['options'] as $isfw_key => $isfw_val ) {
										?>
										<option value="<?php echo esc_attr( $isfw_key ); ?>"
											<?php
											if ( is_array( $isfw_component['value'] ) ) {
												selected( in_array( (string) $isfw_key, $isfw_component['value'], true ), true );
											} else {
												selected( $isfw_component['value'], (string) $isfw_key );
											}
											?>
											>
											<?php echo esc_html( $isfw_val ); ?>
										</option>
										<?php
									}
									?>
								</select>
								<label class="mdl-textfield__label" for="octane"><?php echo esc_html( $isfw_component['description'] ); ?></label>
							</div>
						</div>
					</div>

					<?php
					break;

					case 'checkbox':
					?>
					<div class="mwb-form-group">
						<div class="mwb-form-group__label">
							<label for="<?php echo esc_attr( $isfw_component['id'] ); ?>" class="mwb-form-label"><?php echo esc_html( $isfw_component['title'] ); ?></label>
						</div>
						<div class="mwb-form-group__control mwb-pl-4">
							<div class="mdc-form-field">
								<div class="mdc-checkbox">
									<input 
									name="<?php echo esc_attr( $isfw_component['id'] ); ?>"
									id="<?php echo esc_attr( $isfw_component['id'] ); ?>"
									type="checkbox"
									class="mdc-checkbox__native-control <?php echo esc_attr( isset( $isfw_component['class'] ) ? $isfw_component['class'] : '' ); ?>"
									value="<?php echo esc_attr( $isfw_component['value'] ); ?>"
									<?php checked( $isfw_component['value'], '1' ); ?>
									/>
									<div class="mdc-checkbox__background">
										<svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
											<path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
										</svg>
										<div class="mdc-checkbox__mixedmark"></div>
									</div>
									<div class="mdc-checkbox__ripple"></div>
								</div>
								<label for="checkbox-1"><?php echo esc_html( $isfw_component['description'] ); // WPCS: XSS ok. ?></label>
							</div>
						</div>
					</div>
					<?php
					break;

					case 'radio':
					?>
					<div class="mwb-form-group">
						<div class="mwb-form-group__label">
							<label for="<?php echo esc_attr( $isfw_component['id'] ); ?>" class="mwb-form-label"><?php echo esc_html( $isfw_component['title'] ); ?></label>
						</div>
						<div class="mwb-form-group__control mwb-pl-4">
							<div class="mwb-flex-col">
								<?php
								foreach ( $isfw_component['options'] as $isfw_radio_key => $isfw_radio_val ) {
									?>
									<div class="mdc-form-field">
										<div class="mdc-radio">
											<input
											name="<?php echo esc_attr( $isfw_component['id'] ); ?>"
											value="<?php echo esc_attr( $isfw_radio_key ); ?>"
											type="radio"
											class="mdc-radio__native-control <?php echo esc_attr( $isfw_component['class'] ); ?>"
											<?php checked( $isfw_radio_key, $isfw_component['value'] ); ?>
											>
											<div class="mdc-radio__background">
												<div class="mdc-radio__outer-circle"></div>
												<div class="mdc-radio__inner-circle"></div>
											</div>
											<div class="mdc-radio__ripple"></div>
										</div>
										<label for="radio-1"><?php echo esc_html( $isfw_radio_val ); ?></label>
									</div>	
									<?php
								}
								?>
							</div>
						</div>
					</div>
					<?php
					break;

					case 'radio-switch':
					?>

					<div class="mwb-form-group">
						<div class="mwb-form-group__label">
							<label for="" class="mwb-form-label"><?php echo esc_html( $isfw_component['title'] ); ?></label>
						</div>
						<div class="mwb-form-group__control">
							<div>
								<div class="mdc-switch">
									<div class="mdc-switch__track"></div>
									<div class="mdc-switch__thumb-underlay">
										<div class="mdc-switch__thumb"></div>
										<input name="<?php echo esc_html( $isfw_component['id'] ); ?>" type="checkbox" id="basic-switch" value="on" class="mdc-switch__native-control" role="switch" aria-checked="<?php if ( 'on' == $isfw_component['value'] ) echo 'true'; else echo 'false'; ?>"
										<?php checked( $isfw_component['value'], 'on' ); ?>
										>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					break;

					case 'button':
					?>
					<div class="mwb-form-group">
						<div class="mwb-form-group__label"></div>
						<div class="mwb-form-group__control">
							<button class="mdc-button mdc-button--raised" name="<?php echo esc_attr( $isfw_component['id'] ); ?>"
								id="<?php echo esc_attr( $isfw_component['id'] ); ?>"> <span class="mdc-button__ripple"></span>
								<span class="mdc-button__label"><?php echo esc_attr( $isfw_component['button_text'] ); ?></span>
							</button>
						</div>
					</div>

					<?php
					break;

					case 'submit':
					?>
					<tr valign="top">
						<td scope="row">
							<input type="submit" class="button button-primary" 
							name="<?php echo esc_attr( $isfw_component['id'] ); ?>"
							id="<?php echo esc_attr( $isfw_component['id'] ); ?>"
							value="<?php echo esc_attr( $isfw_component['button_text'] ); ?>"
							/>
						</td>
					</tr>
					<?php
					break;

					case 'multi':
						?>
						<div class="mwb-form-group mwb-isfw-<?php echo esc_attr( $isfw_component['type'] ); ?>">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $isfw_component['id'] ); ?>" class="mwb-form-label"><?php echo esc_html( $isfw_component['title'] ); // WPCS: XSS ok. ?></label>
								</div>
								<div class="mwb-form-group__control">
								<?php
								foreach ( $isfw_component['value'] as $isfw_subcomponent ) {
									?>
										<label class="mdc-text-field mdc-text-field--outlined">
											<span class="mdc-notched-outline">
												<span class="mdc-notched-outline__leading"></span>
												<span class="mdc-notched-outline__notch">
													<?php if ( 'number' != $isfw_subcomponent['type'] ) { ?>
														<span class="mdc-floating-label" id="my-label-id" style=""><?php echo esc_attr( $isfw_subcomponent['placeholder'] ); ?></span>
													<?php } ?>
												</span>
												<span class="mdc-notched-outline__trailing"></span>
											</span>
											<input 
											class="mdc-text-field__input <?php echo esc_attr( $isfw_subcomponent['class'] ); ?>" 
											name="<?php echo esc_attr( $isfw_subcomponent['id'] ); ?>"
											id="<?php echo esc_attr( $isfw_subcomponent['id'] ); ?>"
											type="<?php echo esc_attr( $isfw_subcomponent['type'] ); ?>"
											value="<?php echo esc_attr( $isfw_subcomponent['value'] ); ?>"
											placeholder="<?php echo esc_attr( $isfw_subcomponent['placeholder'] ); ?>"
											>
										</label>
							<?php } ?>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo esc_html( $isfw_component['description'] ); ?></div>
								</div>
							</div>
						</div>
							<?php
						break;
					case 'color':
					case 'date':
					case 'file':
						?>
							<div class="mwb-form-group mwb-isfw-<?php echo esc_attr( $isfw_component['type'] ); ?>">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr( $isfw_component['id'] ); ?>" class="mwb-form-label"><?php echo esc_html( $isfw_component['title'] ); // WPCS: XSS ok. ?></label>
								</div>
								<div class="mwb-form-group__control">
									<label class="mdc-text-field mdc-text-field--outlined">
										<input 
										class="<?php echo esc_attr( $isfw_component['class'] ); ?>" 
										name="<?php echo esc_attr( $isfw_component['id'] ); ?>"
										id="<?php echo esc_attr( $isfw_component['id'] ); ?>"
										type="<?php echo esc_attr( $isfw_component['type'] ); ?>"
										value="<?php echo esc_attr( $isfw_component['value'] ); ?>"
										>
									</label>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo esc_attr( $isfw_component['description'] ); ?></div>
									</div>
								</div>
							</div>
							<?php
						break;
					default:
						break;
				}
			}
		}
	}
}