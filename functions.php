<?php
/**
 * Northline Motors theme bootstrap.
 */
defined( 'ABSPATH' ) || exit;

define( 'NL_THEME_VERSION', '1.0.1' );

require_once get_theme_file_path( 'inc/content.php' );
require_once get_theme_file_path( 'inc/menu.php' );

add_action( 'after_setup_theme', static function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'gallery', 'caption', 'script', 'style' ] );
	add_theme_support( 'custom-logo', [ 'height' => 48, 'width' => 200, 'flex-width' => true ] );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );
	register_nav_menus( [ 'primary' => 'Primary menu', 'footer' => 'Footer menu' ] );
	add_image_size( 'nl-card', 640, 420, true );
	add_image_size( 'nl-hero', 1600, 900, true );
} );

add_action( 'wp_enqueue_scripts', static function () {
	wp_enqueue_style( 'nl-fonts', 'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap', [], null );
	wp_enqueue_style( 'nl-main', get_theme_file_uri( 'assets/css/main.css' ), [], NL_THEME_VERSION );
	wp_enqueue_script( 'nl-main', get_theme_file_uri( 'assets/js/main.js' ), [], NL_THEME_VERSION, [ 'strategy' => 'defer' ] );
	wp_localize_script( 'nl-main', 'nlTheme', [
		'rest'  => esc_url_raw( rest_url( 'northline/v1/' ) ),
		'nonce' => wp_create_nonce( 'wp_rest' ),
	] );
	if ( is_front_page() ) {
		wp_dequeue_style( 'wp-block-library' );
	}
} );

/** Preconnect for fonts. */
add_filter( 'wp_resource_hints', static function ( array $urls, string $relation ) {
	if ( $relation === 'preconnect' ) {
		$urls[] = [ 'href' => 'https://fonts.gstatic.com', 'crossorigin' ];
	}
	return $urls;
}, 10, 2 );

/** Body classes used by CSS. */
add_filter( 'body_class', static function ( array $classes ) {
	if ( is_singular( 'vehicle' ) ) {
		$classes[] = 'is-vehicle';
	}
	return $classes;
} );

/** Inventory archive: respect filters from the query string and the sort order. */
add_action( 'pre_get_posts', static function ( WP_Query $q ) {
	if ( is_admin() || ! $q->is_main_query() || ! class_exists( 'NL_Query' ) ) {
		return;
	}
	if ( $q->is_post_type_archive( 'vehicle' ) || $q->is_tax( array_keys( NL_Post_Types::TAXONOMIES ) ) ) {
		$filters = NL_Query::sanitize( $_GET );
		$filters['paged'] = max( 1, (int) $q->get( 'paged' ) );
		$args = NL_Query::args( $filters );
		foreach ( [ 'posts_per_page', 'meta_query', 'orderby', 'order' ] as $k ) {
			$q->set( $k, $args[ $k ] );
		}
		if ( isset( $args['meta_key'] ) ) {
			$q->set( 'meta_key', $args['meta_key'] );
		}
		if ( $q->is_post_type_archive( 'vehicle' ) && count( $args['tax_query'] ) > 1 ) {
			$q->set( 'tax_query', $args['tax_query'] );
		}
		if ( ! empty( $args['s'] ) ) {
			$q->set( 's', $args['s'] );
		}
	}
} );

/** Excerpt length for blog cards. */
add_filter( 'excerpt_length', static fn () => 22 );
add_filter( 'excerpt_more', static fn () => '…' );

/** Organisation / AutoDealer schema on every page. */
add_action( 'wp_head', static function () {
	$c = nl_content( 'company' );
	$data = [
		'@context'  => 'https://schema.org',
		'@type'     => 'AutoDealer',
		'name'      => get_bloginfo( 'name' ),
		'url'       => home_url( '/' ),
		'telephone' => $c['phone'],
		'email'     => $c['email'],
		'address'   => [ '@type' => 'PostalAddress', 'streetAddress' => $c['address'], 'addressLocality' => $c['city'], 'addressCountry' => $c['country'] ],
		'openingHours' => $c['hours_schema'],
		'sameAs'    => array_values( $c['social'] ),
	];
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}, 20 );

/** Helper: current filter values for form fields. */
function nl_filter_value( string $key ): string {
	return isset( $_GET[ $key ] ) ? sanitize_text_field( wp_unslash( (string) $_GET[ $key ] ) ) : '';
}

/** Helper: inline SVG icon from assets/img/icons.svg sprite. */
function nl_icon( string $name, string $class = '' ): string {
	return '<svg class="icon icon--' . esc_attr( $name ) . ( $class ? ' ' . esc_attr( $class ) : '' ) . '" aria-hidden="true" width="24" height="24"><use href="' . esc_url( get_theme_file_uri( 'assets/img/icons.svg' ) ) . '#' . esc_attr( $name ) . '"></use></svg>';
}
