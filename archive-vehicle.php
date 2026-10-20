<?php
/**
 * Inventory archive and taxonomy archives (make, body, fuel…).
 */
get_header();
$title = 'All vehicles';
if ( is_tax() ) {
	$term  = get_queried_object();
	$title = $term->name;
}
$sort = nl_filter_value( 'sort' ) ?: 'newest';
?>
<section class="page-head">
	<div class="container">
		<nav class="breadcrumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> <span>/</span> <?php if ( is_tax() ) : ?><a href="<?php echo esc_url( get_post_type_archive_link( 'vehicle' ) ); ?>">Inventory</a> <span>/</span> <?php endif; ?><span aria-current="page"><?php echo esc_html( $title ); ?></span></nav>
		<h1><?php echo esc_html( $title ); ?></h1>
		<p class="page-head__sub">Prices are landed-cost estimates to Vancouver port including auction fee, shipping and our commission. Duties and taxes vary by country.</p>
	</div>
</section>
<section class="section section--inventory">
	<div class="container inventory">
		<aside class="inventory__filters">
			<?php get_template_part( 'template-parts/filters' ); ?>
		</aside>
		<div class="inventory__results">
			<div class="inventory__bar">
				<p class="inventory__count"><strong><?php echo (int) $wp_query->found_posts; ?></strong> vehicles found</p>
				<label class="inventory__sort">Sort by
					<select name="sort" data-sort>
						<?php foreach ( [ 'newest' => 'Newest first', 'price_asc' => 'Price: low to high', 'price_desc' => 'Price: high to low', 'year_desc' => 'Year: newest', 'year_asc' => 'Year: oldest', 'km_asc' => 'Mileage: lowest' ] as $k => $label ) : ?>
							<option value="<?php echo esc_attr( $k ); ?>" <?php selected( $sort, $k ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			</div>
			<?php if ( have_posts() ) : ?>
				<div class="vehicle-grid" data-results>
					<?php while ( have_posts() ) : the_post(); echo nl_render_card( get_post() ); endwhile; ?>
				</div>
				<?php if ( $wp_query->max_num_pages > 1 ) : ?>
					<div class="inventory__more">
						<button class="btn btn--ghost" type="button" data-load-more data-page="1" data-pages="<?php echo (int) $wp_query->max_num_pages; ?>">Show more vehicles</button>
						<nav class="pagination" aria-label="Pages"><?php echo paginate_links( [ 'prev_text' => '‹', 'next_text' => '›' ] ); ?></nav>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<div class="empty"><?php echo nl_icon( 'car', 'empty__icon' ); ?><h2>No vehicles match these filters</h2><p>Try widening the year or price range, or <a href="#request">send us a request</a> and we will find the car at auction for you.</p></div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php get_footer();
