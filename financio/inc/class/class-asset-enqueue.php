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
		wp_enqueue_style( 'financio-style', get_stylesheet_uri(), array(), FINANCIO_VERSION );

				wp_enqueue_style( 'presset', FINANCIO_URI . '/assets/css/presset.css', array(), FINANCIO_VERSION );
		wp_enqueue_style( 'custom-styling', FINANCIO_URI . '/assets/css/custom-styling.css', array(), FINANCIO_VERSION );
		wp_enqueue_script( 'animation-script', FINANCIO_URI . '/assets/js/animation-script.js', array(), FINANCIO_VERSION, true );


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
