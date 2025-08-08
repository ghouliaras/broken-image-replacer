<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class BIR_Admin {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'menu' ) );
        add_action( 'admin_init', array( $this, 'settings' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'media' ) );
    }

    public function menu() {
        add_options_page(
            __( 'Broken Image Replacer', 'broken-image-replacer' ),
            __( 'Broken Image Replacer', 'broken-image-replacer' ),
            'manage_options',
            'broken-image-replacer',
            array( $this, 'render' )
        );
    }

    public function settings() {
        register_setting( 'bir_settings_group', 'bir_settings', array( $this, 'sanitize' ) );

        add_settings_section(
            'bir_main',
            __( 'Settings', 'broken-image-replacer' ),
            '__return_false',
            'broken-image-replacer'
        );

        add_settings_field(
            'placeholder_url',
            __( 'Placeholder image URL', 'broken-image-replacer' ),
            array( $this, 'field_placeholder' ),
            'broken-image-replacer',
            'bir_main'
        );

        add_settings_field(
            'apply_in_admin',
            __( 'Also replace images in admin screens', 'broken-image-replacer' ),
            array( $this, 'field_admin' ),
            'broken-image-replacer',
            'bir_main'
        );
    }

    public function sanitize( $input ) {
        $output = bir_default_settings();
        if ( isset( $input['placeholder_url'] ) ) {
            $output['placeholder_url'] = esc_url_raw( $input['placeholder_url'] );
        }
        $output['apply_in_admin'] = ! empty( $input['apply_in_admin'] ) ? 1 : 0;
        return $output;
    }

    public function field_placeholder() {
        $opts = wp_parse_args( get_option( 'bir_settings' ), bir_default_settings() );
        $val  = esc_url( $opts['placeholder_url'] );
        ?>
        <div>
            <input type="url" id="bir_placeholder_url" name="bir_settings[placeholder_url]" value="<?php echo esc_attr( $val ); ?>" class="regular-text" />
            <button type="button" class="button" id="bir_select_image"><?php esc_html_e( 'Select from Media Library', 'broken-image-replacer' ); ?></button>
            <p class="description"><?php esc_html_e( 'URL of the image displayed when an image fails to load. Leave as is to use the built-in SVG.', 'broken-image-replacer' ); ?></p>
        </div>
        <script>
        (function($){
            $('#bir_select_image').on('click', function(e){
                e.preventDefault();
                var frame = wp.media({
                    title: '<?php echo esc_js( __( 'Select Placeholder', 'broken-image-replacer' ) ); ?>',
                    multiple: false
                });
                frame.on('select', function(){
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#bir_placeholder_url').val(attachment.url);
                });
                frame.open();
            });
        })(jQuery);
        </script>
        <?php
    }

    public function field_admin() {
        $opts = wp_parse_args( get_option( 'bir_settings' ), bir_default_settings() );
        ?>
        <label>
            <input type="checkbox" name="bir_settings[apply_in_admin]" value="1" <?php checked( ! empty( $opts['apply_in_admin'] ) ); ?> />
            <?php esc_html_e( 'Enable in wp-admin (useful for broken thumbnails in listings)', 'broken-image-replacer' ); ?>
        </label>
        <?php
    }

    public function render() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'Broken Image Replacer', 'broken-image-replacer' ); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields( 'bir_settings_group' );
                do_settings_sections( 'broken-image-replacer' );
                submit_button();
                ?>
            </form>
            <hr/>
            <h2><?php esc_html_e( 'How it works', 'broken-image-replacer' ); ?></h2>
            <p><?php esc_html_e( 'The plugin attaches a lightweight JavaScript error handler to all images (including dynamically added ones). If an image fails to load, its source is replaced with your placeholder and srcset/sizes are cleared to avoid retry loops.', 'broken-image-replacer' ); ?></p>
            <p><?php esc_html_e( 'To exclude an image, add the attribute', 'broken-image-replacer' ); ?> <code>data-bir-ignore="1"</code>.</p>
        </div>
        <?php
    }

    public function media( $hook ) {
        if ( 'settings_page_broken-image-replacer' === $hook ) {
            wp_enqueue_media();
        }
    }
}

// Initialize admin on admin side
if ( is_admin() ) {
    new BIR_Admin();
}
