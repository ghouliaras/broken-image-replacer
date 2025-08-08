<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class BIR_Plugin {
    private static $instance = null;
    public  $settings = array();

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->settings = wp_parse_args( get_option( 'bir_settings' ), bir_default_settings() );

        add_action( 'init', array( $this, 'init' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

        if ( ! empty( $this->settings['apply_in_admin'] ) ) {
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
        }
    }

    public function init() {
        // Nothing heavy here to keep it clean.
    }

    public function enqueue() {
        $placeholder = isset( $this->settings['placeholder_url'] ) && $this->settings['placeholder_url']
            ? esc_url( $this->settings['placeholder_url'] )
            : esc_url( BIR_URL . 'assets/placeholder.svg' );

        wp_register_script( 'bir-js', BIR_URL . 'assets/js/bir.js', array(), BIR_VERSION, true );
        wp_localize_script( 'bir-js', 'BIR_DATA', array(
            'placeholderUrl' => $placeholder,
        ) );
        wp_enqueue_script( 'bir-js' );

        // Optional minimal CSS (kept inline and tiny to avoid extra request)
        $css = '.bir-placeholder{object-fit:contain;} img[data-bir-ignore]{-webkit-filter:none;filter:none;}';
        wp_add_inline_style( 'wp-block-library', $css ); // piggyback minimal CSS
    }
}
