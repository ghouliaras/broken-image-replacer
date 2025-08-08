<?php
/**
 * Plugin Name: Broken Image Replacer
 * Description: Automatically detects and replaces broken images with a customizable placeholder to maintain a professional appearance.
 * Version: 1.0.0
 * Author: ghouliaras
 * License: GPL-2.0-or-later
 * Text Domain: broken-image-replacer
 * Requires at least: 5.4
 * Requires PHP: 7.2
 *
 * @package BrokenImageReplacer
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'BIR_VERSION', '1.0.0' );
define( 'BIR_FILE', __FILE__ );
define( 'BIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'BIR_URL', plugin_dir_url( __FILE__ ) );

// Default settings
function bir_default_settings() {
    return array(
        'placeholder_url' => BIR_URL . 'assets/placeholder.svg',
        'apply_in_admin'  => 0,
    );
}

// Load files
require_once BIR_PATH . 'includes/class-bir-plugin.php';
require_once BIR_PATH . 'includes/class-bir-admin.php';

// Boot
add_action( 'plugins_loaded', array( 'BIR_Plugin', 'instance' ) );

// Activation: ensure defaults
register_activation_hook( __FILE__, function() {
    $opt = get_option( 'bir_settings' );
    if ( ! is_array( $opt ) ) {
        update_option( 'bir_settings', bir_default_settings() );
    } else {
        $defaults = bir_default_settings();
        update_option( 'bir_settings', wp_parse_args( $opt, $defaults ) );
    }
} );
