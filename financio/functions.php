<?php
/**
 * Theme Functions
 *
 * @author Jegstudio
 * @package financio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

defined( 'FINANCIO_VERSION' ) || define( 'FINANCIO_VERSION', '1.2.1' );
defined( 'FINANCIO_DIR' ) || define( 'FINANCIO_DIR', trailingslashit( get_template_directory() ) );
defined( 'FINANCIO_URI' ) || define( 'FINANCIO_URI', trailingslashit( get_template_directory_uri() ) );

require get_parent_theme_file_path( 'inc/autoload.php' );

Financio\Init::instance();
