<?php
/**
 * Template Name: FAQ
 */
get_header();
the_post();
?>
<section class="page-head"><div class="container"><nav class="breadcrumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> <span>/</span> <span aria-current="page"><?php the_title(); ?></span></nav><h1><?php the_title(); ?></h1></div></section>
<section class="section"><div class="container container--narrow"><?php if ( get_the_content() ) : ?><div class="prose"><?php the_content(); ?></div><?php endif; ?><?php get_template_part( 'template-parts/faq' ); ?></div></section>
<?php get_footer();
