<?php
/**
 * This file adds the Front Page to the Neurogastronomi Theme.
 *
 * @author mono voce aps
 * @package Neurogastronomi
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'neurogastronomi_front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function neurogastronomi_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) ) {

		//* Enqueue scripts
		add_action( 'wp_enqueue_scripts', 'neurogastronomi_enqueue_neurogastronomi_script' );
		function neurogastronomi_enqueue_neurogastronomi_script() {

			// wp_register_style( 'neurogastronomiIE9', get_stylesheet_directory_uri() . '/style-ie9.css', array(), CHILD_THEME_VERSION );
			wp_style_add_data( 'neurogastronomiIE9', 'conditional', 'IE 9' );
			wp_enqueue_style( 'neurogastronomiIE9' );

			wp_enqueue_script( 'neurogastronomi-front-script', get_stylesheet_directory_uri() . '/js/front-page.js', array( 'jquery' ), CHILD_THEME_VERSION );
			wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
			wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );

			// wp_enqueue_style( 'neurogastronomi-front-styles', get_stylesheet_directory_uri() . '/style-front.css', array(), CHILD_THEME_VERSION );

		}

		//* Enqueue scripts for backstretch
		add_action( 'wp_enqueue_scripts', 'neurogastronomi_front_page_enqueue_scripts' );
		function neurogastronomi_front_page_enqueue_scripts() {

			$image = get_option( 'neurogastronomi-front-image', sprintf( '%s/images/front-page-1.jpg', get_stylesheet_directory_uri() ) );

			//* Load scripts only if custom backstretch image is being used
			if ( ! empty( $image ) && is_active_sidebar( 'front-page-1' ) ) {

				//* Enqueue Backstretch scripts
				wp_enqueue_script( 'neurogastronomi-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch.js', array( 'jquery' ), '1.0.0' );
				wp_enqueue_script( 'neurogastronomi-backstretch-set', get_bloginfo('stylesheet_directory').'/js/backstretch-set.js' , array( 'jquery', 'neurogastronomi-backstretch' ), '1.0.0' );

				wp_localize_script( 'neurogastronomi-backstretch-set', 'BackStretchImg', array( 'src' => str_replace( 'http:', '', $image ) ) );

			}

		}

		//* Add front-page body class
		add_filter( 'body_class', 'neurogastronomi_body_class' );
		function neurogastronomi_body_class( $classes ) {

			$classes[] = 'front-page';

			return $classes;

		}

		//* Force full width content layout
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Add widgets on front page
		add_action( 'genesis_after_header', 'neurogastronomi_front_page_widgets' );

		$journal = get_option( 'neurogastronomi_journal_setting', 'true' );

		if ( 'true' === $journal ) {

			//* Add opening markup for blog section
			add_action( 'genesis_before_loop', 'neurogastronomi_front_page_blog_open' );

			//* Add closing markup for blog section
			add_action( 'genesis_after_loop', 'neurogastronomi_front_page_blog_close' );

		} else {

			//* Remove the default Genesis loop
			remove_action( 'genesis_loop', 'genesis_do_loop' );

			//* Remove .site-inner
			add_filter( 'genesis_markup_site-inner', '__return_null' );
			add_filter( 'genesis_markup_content-sidebar-wrap_output', '__return_false' );
			add_filter( 'genesis_markup_content', '__return_null' );

		}

	}

}

//* Add widgets on front page
function neurogastronomi_front_page_widgets() {

	if ( get_query_var( 'paged' ) >= 2 )
		return;

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'neurogastronomi' ) . '</h2>';

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div id="front-page-1" class="front-page-1"><div class="widget-area fadeup-effect"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div id="front-page-2" class="front-page-2"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . neurogastronomi_halves_widget_area_class( 'front-page-2' ) . '">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . neurogastronomi_widget_area_class( 'front-page-3' ) . '">',
		'after'  => '</div></div></div>',
	) );
	
	genesis_widget_area( 'front-page-4', array(
		'before' => '<div id="front-page-4" class="front-page-4"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . neurogastronomi_widget_area_class( 'front-page-4' ) . '">',
		'after'  => '</div></div></div>',
	) );
	
	genesis_widget_area( 'front-page-5', array(
		'before' => '<div id="front-page-5" class="front-page-5"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . neurogastronomi_widget_area_class( 'front-page-5' ) . '">',
		'after'  => '</div></div></div>',
	) );
	
	genesis_widget_area( 'front-page-6', array(
		'before' => '<div id="front-page-6" class="front-page-6"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . neurogastronomi_widget_area_class( 'front-page-6' ) . '">',
		'after'  => '</div></div></div>',
	) );

}

//* Add opening markup for blog section
function neurogastronomi_front_page_blog_open() {

	$journal_text = get_option( 'neurogastronomi_journal_text', __( 'Our Journal', 'neurogastronomi' ) );
	
	if ( 'posts' == get_option( 'show_on_front' ) ) {

		echo '<div id="journal" class="widget-area fadeup-effect"><div class="wrap">';

		if ( ! empty( $journal_text ) ) {

			echo '<h2 class="widgettitle widget-title center">' . $journal_text . '</h2>';

		}

	}

}

//* Add closing markup for blog section
function neurogastronomi_front_page_blog_close() {

	if ( 'posts' == get_option( 'show_on_front' ) ) {

		echo '</div></div>';

	}

}

//* Run the Genesis function
genesis();
