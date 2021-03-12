<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com/
 * @since             1.0.0
 * @package           Invoice_system_for_woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       invoice-system-for-woocommerce
 * Plugin URI:        https://makewebbetter.com/product/invoice-system-for-woocommerce/
 * Description:       Plugin will create invoice and packing slip, you can send invoice with mail.make sure woocommerce plugin is activated before activating this.
 * Version:           1.0.0
 * Author:            makewebbetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       invoice-system-for-woocommerce
 * Domain Path:       /languages
 *
 * Requires at least: 4.6
 * Tested up to:      4.9.5
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
/**
 * Checking dependency for woocommerce plugin.
 *
 * @return void
 */
function isfw_dependency_checkup() {
	if ( ! in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ), true ) ) {
		add_action( 'admin_init', 'isfw_deactivate_child_plugin' );
		add_action( 'admin_notices', 'isfw_show_admin_notices' );
	}
}
add_action( 'plugins_loaded', 'isfw_dependency_checkup' );
/**
 * Deactivating child plugin.
 *
 * @return void
 */
function isfw_deactivate_child_plugin() {
	deactivate_plugins( plugin_basename( __FILE__ ) );
}
/**
 * Showing admin notices.
 *
 * @return void
 */
function isfw_show_admin_notices() {
	$isfw_child_plugin  = __( 'Invoice system for woocommerce', 'invoice-system-for-woocommerce' );
	$isfw_parent_plugin = __( 'Woocommerce', 'invoice-system-for-woocommerce' );
	echo '<div class="error"><p>'
		. sprintf( __( '%1$s requires %2$s to function correctly. Please activate %2$s before activating %1$s. For now, the plugin has been deactivated.', 'invoice-system-for-woocommerce' ), '<strong>' . esc_html( $isfw_child_plugin ) . '</strong>', '<strong>' . esc_html( $isfw_parent_plugin ) . '</strong>' )
		. '</p></div>';

	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}
/**
 * Define plugin constants.
 *
 * @since             1.0.0
 */
function define_invoice_system_for_woocommerce_constants() {

	invoice_system_for_woocommerce_constants( 'INVOICE_SYSTEM_FOR_WOOCOMMERCE_VERSION', '1.0.0' );
	invoice_system_for_woocommerce_constants( 'INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH', plugin_dir_path( __FILE__ ) );
	invoice_system_for_woocommerce_constants( 'INVOICE_SYSTEM_FOR_WOOCOMMERCE_DIR_URL', plugin_dir_url( __FILE__ ) );
	invoice_system_for_woocommerce_constants( 'INVOICE_SYSTEM_FOR_WOOCOMMERCE_SERVER_URL', 'https://makewebbetter.com' );
	invoice_system_for_woocommerce_constants( 'INVOICE_SYSTEM_FOR_WOOCOMMERCE_ITEM_REFERENCE', 'invoice-system-for-woocommerce' );
}


/**
 * Callable function for defining plugin constants.
 *
 * @param   String $key    Key for contant.
 * @param   String $value   value for contant.
 * @since             1.0.0
 */
function invoice_system_for_woocommerce_constants( $key, $value ) {

	if ( ! defined( $key ) ) {

		define( $key, $value );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-invoice-system-for-woocommerce-activator.php
 */
function activate_invoice_system_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-invoice-system-for-woocommerce-activator.php';
	Invoice_system_for_woocommerce_Activator::invoice_system_for_woocommerce_activate();
	$mwb_isfw_active_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_isfw_active_plugin ) && ! empty( $mwb_isfw_active_plugin ) ) {
		$mwb_isfw_active_plugin['invoice-system-for-woocommerce'] = array(
			'plugin_name' => __( 'invoice-system-for-woocommerce', 'invoice-system-for-woocommerce' ),
			'active' => '1',
		);
	} else {
		$mwb_isfw_active_plugin = array();
		$mwb_isfw_active_plugin['invoice-system-for-woocommerce'] = array(
			'plugin_name' => __( 'invoice-system-for-woocommerce', 'invoice-system-for-woocommerce' ),
			'active' => '1',
		);
	}
	update_option( 'mwb_all_plugins_active', $mwb_isfw_active_plugin );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-invoice-system-for-woocommerce-deactivator.php
 */
function deactivate_invoice_system_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-invoice-system-for-woocommerce-deactivator.php';
	Invoice_system_for_woocommerce_Deactivator::invoice_system_for_woocommerce_deactivate();
	$mwb_isfw_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_isfw_deactive_plugin ) && ! empty( $mwb_isfw_deactive_plugin ) ) {
		foreach ( $mwb_isfw_deactive_plugin as $mwb_isfw_deactive_key => $mwb_isfw_deactive ) {
			if ( 'invoice-system-for-woocommerce' === $mwb_isfw_deactive_key ) {
				$mwb_isfw_deactive_plugin[ $mwb_isfw_deactive_key ]['active'] = '0';
			}
		}
	}
	update_option( 'mwb_all_plugins_active', $mwb_isfw_deactive_plugin );
}

register_activation_hook( __FILE__, 'activate_invoice_system_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_invoice_system_for_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-invoice-system-for-woocommerce.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_invoice_system_for_woocommerce() {
	define_invoice_system_for_woocommerce_constants();

	$isfw_plugin_standard = new Invoice_system_for_woocommerce();
	$isfw_plugin_standard->isfw_run();
	$GLOBALS['isfw_mwb_isfw_obj'] = $isfw_plugin_standard;

}
run_invoice_system_for_woocommerce();


// Add settings link on plugin page.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'invoice_system_for_woocommerce_settings_link' );

/**
 * Settings link.
 *
 * @since    1.0.0
 * @param   Array $links    Settings link array.
 */
function invoice_system_for_woocommerce_settings_link( $links ) {

	$my_link = array(
		'<a href="' . admin_url( 'admin.php?page=invoice_system_for_woocommerce_menu' ) . '">' . __( 'Settings', 'invoice-system-for-woocommerce' ) . '</a>',
	);
	return array_merge( $my_link, $links );
}
