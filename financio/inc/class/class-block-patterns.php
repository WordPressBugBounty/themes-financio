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

use WP_Block_Pattern_Categories_Registry;

/**
 * Init Class
 *
 * @package financio
 */
class Block_Patterns {

	/**
	 * Instance variable
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Class instance.
	 *
	 * @return BlockPatterns
	 */
	public static function instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->register_block_patterns();
		$this->register_synced_patterns();
	}

	/**
	 * Register Block Patterns
	 */
	private function register_block_patterns() {
		$block_pattern_categories = array(
			'financio-core' => array( 'label' => __( 'Financio Core Patterns', 'financio' ) ),
		);

		if ( defined( 'GUTENVERSE' ) ) {
			$block_pattern_categories['financio-gutenverse'] = array( 'label' => __( 'Financio Gutenverse Patterns', 'financio' ) );
			$block_pattern_categories['financio-pro'] = array( 'label' => __( 'Financio Gutenverse PRO Patterns', 'financio' ) );
		}

		$block_pattern_categories = apply_filters( 'financio_block_pattern_categories', $block_pattern_categories );

		foreach ( $block_pattern_categories as $name => $properties ) {
			if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
				register_block_pattern_category( $name, $properties );
			}
		}

		$block_patterns = array(
            'financio-404',			'financio-hero-archive-title',			'financio-section-3',			'financio-feature',			'financio-section-4',			'financio-feature-2',			'financio-faq',			'financio-call-to-action',			'financio-hero-index-title',			'financio-post-title',			'financio-hero-search-title',			'financio-post-title',
		);

		if ( defined( 'GUTENVERSE' ) ) {
            $block_patterns[] = 'financio-gutenverse-footer';			$block_patterns[] = 'financio-gutenverse-header';			$block_patterns[] = 'financio-gutenverse-404-title';			$block_patterns[] = 'financio-gutenverse-about-title';			$block_patterns[] = 'financio-gutenverse-section-2';			$block_patterns[] = 'financio-gutenverse-cta';			$block_patterns[] = 'financio-gutenverse-team';			$block_patterns[] = 'financio-gutenverse-archive-title';			$block_patterns[] = 'financio-gutenverse-blog-title';			$block_patterns[] = 'financio-gutenverse-blog-content';			$block_patterns[] = 'financio-gutenverse-contact-title';			$block_patterns[] = 'financio-gutenverse-contact-content';			$block_patterns[] = 'financio-gutenverse-faq-title';			$block_patterns[] = 'financio-gutenverse-faq-content';			$block_patterns[] = 'financio-gutenverse-hero';			$block_patterns[] = 'financio-gutenverse-feature-2';			$block_patterns[] = 'financio-gutenverse-section-1';			$block_patterns[] = 'financio-gutenverse-feature';			$block_patterns[] = 'financio-gutenverse-description';			$block_patterns[] = 'financio-gutenverse-cta';			$block_patterns[] = 'financio-gutenverse-team';			$block_patterns[] = 'financio-gutenverse-index-title';			$block_patterns[] = 'financio-gutenverse-page-title';			$block_patterns[] = 'financio-gutenverse-search-title';			$block_patterns[] = 'financio-gutenverse-service-title';			$block_patterns[] = 'financio-gutenverse-service-content';			$block_patterns[] = 'financio-gutenverse-testimonial';			$block_patterns[] = 'financio-gutenverse-faq';			$block_patterns[] = 'financio-gutenverse-single-title';			$block_patterns[] = 'financio-gutenverse-single-content';
            
		}

		$block_patterns = apply_filters( 'financio_block_patterns', $block_patterns );
		$pattern_list   = get_option( 'financio_synced_pattern_imported', false );
		if ( ! $pattern_list ) {
			$pattern_list = array();
		}

		if ( function_exists( 'register_block_pattern' ) ) {
			foreach ( $block_patterns as $block_pattern ) {
				$pattern_file = get_theme_file_path( '/inc/patterns/' . $block_pattern . '.php' );
				$pattern_data = require $pattern_file;

				if ( (bool) $pattern_data['is_sync'] ) {
					$post = get_page_by_path( $block_pattern . '-synced', OBJECT, 'wp_block' );
					if ( empty( $post ) ) {
						$post_id = wp_insert_post(
							array(
								'post_name'    => $block_pattern . '-synced',
								'post_title'   => $pattern_data['title'],
								'post_content' => wp_slash( $pattern_data['content'] ),
								'post_status'  => 'publish',
								'post_author'  => 1,
								'post_type'    => 'wp_block',
							)
						);
						if ( ! is_wp_error( $post_id ) ) {
							$pattern_category = $pattern_data['categories'];
							foreach( $pattern_category as $category ){
								wp_set_object_terms( $post_id, $category, 'wp_pattern_category' );
							}
						}
						$pattern_data['content']  = '<!-- wp:block {"ref":' . $post_id . '} /-->';
						$pattern_data['inserter'] = false;
						$pattern_data['slug']     = $block_pattern;

						$pattern_list[] = $pattern_data;
					}
				} else {
					register_block_pattern(
						'financio/' . $block_pattern,
						require $pattern_file
					);
				}
			}
			update_option( 'financio_synced_pattern_imported', $pattern_list );
		}
	}

	/**
	 * Register Synced Patterns
	 */
	 private function register_synced_patterns() {
		$patterns = get_option( 'financio_synced_pattern_imported' );

		 foreach ( $patterns as $block_pattern ) {
			 register_block_pattern(
				'financio/' . $block_pattern['slug'],
				$block_pattern
			);
		 }
	 }
}
