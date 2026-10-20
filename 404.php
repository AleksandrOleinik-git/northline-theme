<?php get_header(); ?>
<section class="section">
	<div class="container empty">
		<?php echo nl_icon( 'car', 'empty__icon' ); ?>
		<h1>Page not found</h1>
		<p>The page may have moved, or the car has been sold. Browse the <a href="<?php echo esc_url( get_post_type_archive_link( 'vehicle' ) ); ?>">inventory</a> or go <a href="<?php echo esc_url( home_url( '/' ) ); ?>">home</a>.</p>
	</div>
</section>
<?php get_footer();
