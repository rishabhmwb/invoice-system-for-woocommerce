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
 * @package           Invoice_system_for_woocommere
 *
 * @wordpress-plugin
 * Plugin Name:       invoice-system-for-woocommere
 * Plugin URI:        https://makewebbetter.com/product/invoice-system-for-woocommere/
 * Description:       This plugin will generate invoice pdf.
 * Version:           1.0.0
 * Author:            makewebbetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       invoice-system-for-woocommere
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
 * Define plugin constants.
 *
 * @since             1.0.0
 */
function define_invoice_system_for_woocommere_constants() {

	invoice_system_for_woocommere_constants( 'INVOICE_SYSTEM_FOR_WOOCOMMERE_VERSION', '1.0.0' );
	invoice_system_for_woocommere_constants( 'INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_PATH', plugin_dir_path( __FILE__ ) );
	invoice_system_for_woocommere_constants( 'INVOICE_SYSTEM_FOR_WOOCOMMERE_DIR_URL', plugin_dir_url( __FILE__ ) );
	invoice_system_for_woocommere_constants( 'INVOICE_SYSTEM_FOR_WOOCOMMERE_SERVER_URL', 'https://makewebbetter.com' );
	invoice_system_for_woocommere_constants( 'INVOICE_SYSTEM_FOR_WOOCOMMERE_ITEM_REFERENCE', 'invoice-system-for-woocommere' );
}


/**
 * Callable function for defining plugin constants.
 *
 * @param   String $key    Key for contant.
 * @param   String $value   value for contant.
 * @since             1.0.0
 */
function invoice_system_for_woocommere_constants( $key, $value ) {

	if ( ! defined( $key ) ) {

		define( $key, $value );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-invoice-system-for-woocommere-activator.php
 */
function activate_invoice_system_for_woocommere() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-invoice-system-for-woocommere-activator.php';
	Invoice_system_for_woocommere_Activator::invoice_system_for_woocommere_activate();
	$mwb_isfw_active_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_isfw_active_plugin ) && ! empty( $mwb_isfw_active_plugin ) ) {
		$mwb_isfw_active_plugin['invoice-system-for-woocommere'] = array(
			'plugin_name' => __( 'invoice-system-for-woocommere', 'invoice-system-for-woocommere' ),
			'active' => '1',
		);
	} else {
		$mwb_isfw_active_plugin = array();
		$mwb_isfw_active_plugin['invoice-system-for-woocommere'] = array(
			'plugin_name' => __( 'invoice-system-for-woocommere', 'invoice-system-for-woocommere' ),
			'active' => '1',
		);
	}
	update_option( 'mwb_all_plugins_active', $mwb_isfw_active_plugin );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-invoice-system-for-woocommere-deactivator.php
 */
function deactivate_invoice_system_for_woocommere() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-invoice-system-for-woocommere-deactivator.php';
	Invoice_system_for_woocommere_Deactivator::invoice_system_for_woocommere_deactivate();
	$mwb_isfw_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_isfw_deactive_plugin ) && ! empty( $mwb_isfw_deactive_plugin ) ) {
		foreach ( $mwb_isfw_deactive_plugin as $mwb_isfw_deactive_key => $mwb_isfw_deactive ) {
			if ( 'invoice-system-for-woocommere' === $mwb_isfw_deactive_key ) {
				$mwb_isfw_deactive_plugin[ $mwb_isfw_deactive_key ]['active'] = '0';
			}
		}
	}
	update_option( 'mwb_all_plugins_active', $mwb_isfw_deactive_plugin );
}

register_activation_hook( __FILE__, 'activate_invoice_system_for_woocommere' );
register_deactivation_hook( __FILE__, 'deactivate_invoice_system_for_woocommere' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-invoice-system-for-woocommere.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_invoice_system_for_woocommere() {
	define_invoice_system_for_woocommere_constants();

	$isfw_plugin_standard = new Invoice_system_for_woocommere();
	$isfw_plugin_standard->isfw_run();
	$GLOBALS['isfw_mwb_isfw_obj'] = $isfw_plugin_standard;

}
run_invoice_system_for_woocommere();


// Add settings link on plugin page.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'invoice_system_for_woocommere_settings_link' );

/**
 * Settings link.
 *
 * @since    1.0.0
 * @param   Array $links    Settings link array.
 */
function invoice_system_for_woocommere_settings_link( $links ) {

	$my_link = array(
		'<a href="' . admin_url( 'admin.php?page=invoice_system_for_woocommere_menu' ) . '">' . __( 'Settings', 'invoice-system-for-woocommere' ) . '</a>',
	);
	return array_merge( $my_link, $links );
}