<?php
/**
 * Template Name: Reviews
 */
get_header();
the_post();
?>
<section class="page-head"><div class="container"><nav class="breadcrumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> <span>/</span> <span aria-current="page"><?php the_title(); ?></span></nav><h1><?php the_title(); ?></h1>
	<ul class="rating-sources"><?php foreach ( nl_content( 'rating_sources' ) as [ $src, $rating, $n ] ) : ?><li><strong><?php echo esc_html( $rating ); ?></strong> <?php echo nl_icon( 'star' ); ?> <span><?php echo esc_html( $src ); ?>, <?php echo esc_html( $n ); ?> reviews</span></li><?php endforeach; ?></ul></div></section>
<section class="section"><div class="container">
	<div class="reviews reviews--grid">
		<?php foreach ( nl_content( 'reviews' ) as [ $name, $city, $stars, $car, $text ] ) : ?>
			<blockquote class="review"><p class="review__stars" aria-label="<?php echo (int) $stars; ?> out of 5"><?php echo str_repeat( nl_icon( 'star' ), $stars ); ?></p><p><?php echo esc_html( $text ); ?></p><footer><strong><?php echo esc_html( $name ); ?></strong>, <?php echo esc_html( $city ); ?> · <?php echo esc_html( $car ); ?></footer></blockquote>
		<?php endforeach; ?>
	</div>
	<?php if ( get_the_content() ) : ?><div class="container--narrow prose"><?php the_content(); ?></div><?php endif; ?>
</div></section>
<?php get_footer();
