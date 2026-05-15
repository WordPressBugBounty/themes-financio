<?php
/**
 * Block Pattern Class
 *
 * @author Jegstudio
 * @package financio
 */
namespace Financio;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Init Class
 *
 * @package financio
 */
class Asset_Enqueue {
	/**
	 * Class constructor.
	 */
	public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );
		add_action( 'enqueue_block_assets', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ), 20 );
	}

    /**
	 * Enqueue scripts and styles.
	 */
	public function enqueue_scripts() {
		wp_register_style(
			'financio-style',
			get_stylesheet_uri(),
			array(),
			FINANCIO_VERSION
		);

		wp_style_add_data( 'financio-style', 'path', FINANCIO_DIR );
		
		wp_enqueue_style( 'financio-style' );

				wp_register_style( 'presset', trailingslashit( get_template_directory_uri() ) . 'assets/css/presset.css', array(), FINANCIO_VERSION );
		if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/css/presset.css' ) && filesize( trailingslashit( get_template_directory() ) . 'assets/css/presset.css' ) < 51200 ) {
			wp_style_add_data( 'presset', 'path', trailingslashit( get_template_directory() ) . 'assets/css/presset.css' );
		}
		wp_enqueue_style( 'presset' );
		wp_register_style( 'custom-styling', trailingslashit( get_template_directory_uri() ) . 'assets/css/custom-styling.css', array(), FINANCIO_VERSION );
		if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/css/custom-styling.css' ) && filesize( trailingslashit( get_template_directory() ) . 'assets/css/custom-styling.css' ) < 51200 ) {
			wp_style_add_data( 'custom-styling', 'path', trailingslashit( get_template_directory() ) . 'assets/css/custom-styling.css' );
		}
		wp_enqueue_style( 'custom-styling' );
		wp_register_script( 'animation-script', trailingslashit( get_template_directory_uri() ) . 'assets/js/animation-script.js', array(), FINANCIO_VERSION, true );
		wp_enqueue_script( 'animation-script' );


        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
    }

	/**
	 * Enqueue admin scripts and styles.
	 */
	public function admin_scripts() {
		
    }
}
