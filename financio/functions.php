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

defined( 'FINANCIO_VERSION' ) || define( 'FINANCIO_VERSION', '1.3.0' );
defined( 'FINANCIO_DIR' ) || define( 'FINANCIO_DIR', trailingslashit( get_template_directory() ) );

defined( 'GUTENVERSE_COMPANION_REQUIRED_VERSION' ) || define( 'GUTENVERSE_COMPANION_REQUIRED_VERSION', '2.3.3' );
defined( 'GUTENVERSE_LIBRARY_SERVER' ) || define( 'GUTENVERSE_LIBRARY_SERVER', 'https://gutenverse.com' );

require get_parent_theme_file_path( 'inc/autoload.php' );

Financio\Init::instance();
