<?php
/**
 * Infinite Scroll Theme Assets
 *
 * Register support for Twenty Seventeen.
 */

/**
 * Add theme support for infinite scroll
 */
function twentyseventeen_infinite_scroll_init() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'twentyseventeen_infinite_scroll_render',
		'footer'    => 'content',
	) );
}
add_action( 'after_setup_theme', 'twentyseventeen_infinite_scroll_init' );

/**
 * Custom render function for Infinite Scroll.
 */
function twentyseventeen_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) {
			get_template_part( 'template-parts/post/content', 'search' );
		} else {
			get_template_part( 'template-parts/post/content', get_post_format() );
		}
	}
}

/**
 * Enqueue CSS stylesheet with theme styles for Infinite Scroll.
 */
function twentyseventeen_infinite_scroll_enqueue_styles() {
	if ( wp_script_is( 'the-neverending-homepage' ) ) {
		wp_enqueue_style( 'infinity-twentyseventeen', plugins_url( 'twentyseventeen.css', __FILE__ ), array( 'the-neverending-homepage' ), '20161219' );
		wp_style_add_data( 'infinity-twentyseventeen', 'rtl', 'replace' );
	}
}
add_action( 'wp_enqueue_scripts', 'twentyseventeen_infinite_scroll_enqueue_styles', 25 );
