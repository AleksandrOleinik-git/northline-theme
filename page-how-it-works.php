<?php
/**
 * Template Name: How it works
 */
get_header();
the_post();
?>
<section class="page-head"><div class="container"><nav class="breadcrumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> <span>/</span> <span aria-current="page"><?php the_title(); ?></span></nav><h1><?php the_title(); ?></h1></div></section>
<section class="section">
	<div class="container">
		<ol class="process process--vertical">
			<?php foreach ( nl_content( 'process' ) as $i => [ $title, $text ] ) : ?>
				<li class="process__step"><span class="process__num"><?php echo (int) $i + 1; ?></span><h2><?php echo esc_html( $title ); ?></h2><p><?php echo esc_html( $text ); ?></p></li>
			<?php endforeach; ?>
		</ol>
		<?php if ( get_the_content() ) : ?><div class="container--narrow prose"><?php the_content(); ?></div><?php endif; ?>
		<h2 class="section__title">Why buy through Northline</h2>
		<div class="advantages">
			<?php foreach ( nl_content( 'advantages' ) as [ $icon, $title, $text ] ) : ?>
				<div class="advantage"><?php echo nl_icon( $icon, 'advantage__icon' ); ?><h3><?php echo esc_html( $title ); ?></h3><p><?php echo esc_html( $text ); ?></p></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php get_footer();
