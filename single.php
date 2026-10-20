<?php
/**
 * Blog post.
 */
get_header();
the_post();
?>
<section class="page-head">
	<div class="container">
		<nav class="breadcrumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> <span>/</span> <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Blog</a> <span>/</span> <span aria-current="page"><?php the_title(); ?></span></nav>
		<h1><?php the_title(); ?></h1>
		<p class="page-head__meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time> · <?php echo esc_html( get_the_author() ); ?></p>
	</div>
</section>
<section class="section">
	<article class="container container--narrow prose">
		<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'nl-hero', [ 'class' => 'prose__cover' ] ); } ?>
		<?php the_content(); ?>
	</article>
</section>
<?php get_footer();
