<?php
/**
 * Blog index, categories, search and any other archive.
 */
get_header();
$title = is_home() ? 'Blog' : ( is_search() ? 'Search: ' . get_search_query() : wp_strip_all_tags( get_the_archive_title() ) );
?>
<section class="page-head">
	<div class="container">
		<nav class="breadcrumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> <span>/</span> <span aria-current="page"><?php echo esc_html( $title ); ?></span></nav>
		<h1><?php echo esc_html( $title ); ?></h1>
	</div>
</section>
<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="post-grid">
				<?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/post-card', null, [ 'post' => get_post() ] ); endwhile; ?>
			</div>
			<nav class="pagination" aria-label="Pages"><?php echo paginate_links( [ 'prev_text' => '‹', 'next_text' => '›' ] ); ?></nav>
		<?php else : ?>
			<div class="empty"><h2>Nothing found</h2><p>Try another search or browse the <a href="<?php echo esc_url( get_post_type_archive_link( 'vehicle' ) ); ?>">inventory</a>.</p></div>
		<?php endif; ?>
	</div>
</section>
<?php get_footer();
