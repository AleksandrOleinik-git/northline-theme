<?php
defined( 'ABSPATH' ) || exit;
$p = $args['post'] ?? get_post();
?>
<article class="post-card">
	<a class="post-card__media" href="<?php echo esc_url( get_permalink( $p ) ); ?>" tabindex="-1" aria-hidden="true"><?php echo get_the_post_thumbnail( $p, 'nl-card', [ 'loading' => 'lazy' ] ) ?: '<span class="post-card__placeholder">' . nl_icon( 'doc' ) . '</span>'; ?></a>
	<div class="post-card__body">
		<time datetime="<?php echo esc_attr( get_the_date( 'c', $p ) ); ?>"><?php echo esc_html( get_the_date( '', $p ) ); ?></time>
		<h3><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a></h3>
		<p><?php echo esc_html( get_the_excerpt( $p ) ); ?></p>
	</div>
</article>
