<?php
defined( 'ABSPATH' ) || exit;

/** Fallback menu when no menu is assigned yet. */
function nl_default_menu( array $args ): void {
	$items = [
		'Inventory'    => get_post_type_archive_link( 'vehicle' ),
		'How it works' => home_url( '/how-it-works/' ),
		'About'        => home_url( '/about/' ),
		'Reviews'      => home_url( '/reviews/' ),
		'FAQ'          => home_url( '/faq/' ),
		'Blog'         => home_url( '/blog/' ),
		'Contact'      => home_url( '/contact/' ),
	];
	echo '<ul class="' . esc_attr( $args['menu_class'] ?? 'menu' ) . '">';
	foreach ( $items as $label => $url ) {
		echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}
