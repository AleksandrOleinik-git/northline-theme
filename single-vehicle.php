<?php
/**
 * Single vehicle page.
 */
get_header();
the_post();
$id      = get_the_ID();
$gallery = nl_vehicle_gallery( $id );
$specs   = nl_vehicle_specs( $id );
$price   = nl_vehicle_meta( $id, 'price_usd' );
$status  = nl_vehicle_term( $id, 'status' );
$make    = get_the_terms( $id, 'vehicle_make' );
$make    = $make && ! is_wp_error( $make ) ? $make[0] : null;
?>
<script type="application/ld+json"><?php echo nl_vehicle_jsonld( $id ); ?></script>
<section class="page-head page-head--slim">
	<div class="container">
		<nav class="breadcrumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> <span>/</span> <a href="<?php echo esc_url( get_post_type_archive_link( 'vehicle' ) ); ?>">Inventory</a> <span>/</span> <?php if ( $make ) : ?><a href="<?php echo esc_url( get_term_link( $make ) ); ?>"><?php echo esc_html( $make->name ); ?></a> <span>/</span> <?php endif; ?><span aria-current="page"><?php the_title(); ?></span></nav>
	</div>
</section>
<article class="vehicle container">
	<div class="vehicle__main">
		<div class="gallery" data-gallery>
			<div class="gallery__stage">
				<?php if ( $gallery ) : ?>
					<?php echo wp_get_attachment_image( $gallery[0], 'large', false, [ 'class' => 'gallery__img', 'data-index' => 0, 'fetchpriority' => 'high' ] ); ?>
				<?php else : ?>
					<span class="gallery__placeholder"><?php echo nl_icon( 'car' ); ?></span>
				<?php endif; ?>
				<?php if ( $status ) : ?><span class="badge badge--<?php echo esc_attr( sanitize_title( $status ) ); ?>"><?php echo esc_html( $status ); ?></span><?php endif; ?>
				<?php if ( count( $gallery ) > 1 ) : ?>
					<button class="gallery__nav gallery__nav--prev" type="button" aria-label="Previous photo" data-prev><?php echo nl_icon( 'chevron' ); ?></button>
					<button class="gallery__nav gallery__nav--next" type="button" aria-label="Next photo" data-next><?php echo nl_icon( 'chevron' ); ?></button>
				<?php endif; ?>
			</div>
			<?php if ( count( $gallery ) > 1 ) : ?>
				<ul class="gallery__thumbs">
					<?php foreach ( $gallery as $i => $att ) : ?>
						<li><button type="button" class="<?php echo $i === 0 ? 'is-active' : ''; ?>" data-full="<?php echo esc_url( wp_get_attachment_image_url( $att, 'large' ) ); ?>" data-index="<?php echo (int) $i; ?>" aria-label="<?php echo get_post_meta( $att, '_nl_is_sheet', true ) ? 'Auction sheet' : 'Photo ' . ( (int) $i + 1 ); ?>"><?php if ( get_post_meta( $att, '_nl_is_sheet', true ) ) : ?><span class="gallery__tag">Sheet</span><?php endif; ?><?php echo wp_get_attachment_image( $att, 'thumbnail', false, [ 'loading' => 'lazy' ] ); ?></button></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<section class="vehicle__specs">
			<h2>Specifications</h2>
			<dl class="specs">
				<?php foreach ( $specs as $label => $value ) : ?>
					<div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( (string) $value ); ?></dd></div>
				<?php endforeach; ?>
			</dl>
		</section>

		<?php $features = nl_vehicle_features( $id ); if ( $features ) : ?>
			<section class="vehicle__features">
				<h2>Equipment</h2>
				<ul class="features">
					<?php foreach ( $features as $f ) : ?><li><?php echo nl_icon( 'check' ); ?><?php echo esc_html( $f ); ?></li><?php endforeach; ?>
				</ul>
			</section>
		<?php endif; ?>

		<?php if ( get_the_content() ) : ?>
			<section class="vehicle__description prose"><h2>About this car</h2><?php the_content(); ?></section>
		<?php endif; ?>
	</div>

	<aside class="vehicle__side">
		<div class="pricebox">
			<h1 class="pricebox__title"><?php the_title(); ?></h1>
			<p class="pricebox__summary"><?php echo esc_html( nl_vehicle_summary( $id ) ); ?></p>
			<p class="pricebox__price"><?php echo esc_html( nl_format_price( $price ) ); ?></p>
			<p class="pricebox__note">Landed-cost estimate to Vancouver port: auction price, auction fees, inland transport, sea freight and our fixed commission. Import duties and taxes are not included.</p>
			<?php if ( $price !== '' ) : ?>
				<div class="breakdown" data-breakdown data-price="<?php echo (int) $price; ?>">
					<button class="breakdown__toggle" type="button" aria-expanded="false">What makes up the price <?php echo nl_icon( 'chevron' ); ?></button>
					<ul class="breakdown__list" hidden>
						<li><span>Vehicle at auction</span><strong data-part="0.72"></strong></li>
						<li><span>Auction fees and export paperwork</span><strong data-part="0.06"></strong></li>
						<li><span>Inland transport and sea freight</span><strong data-part="0.14"></strong></li>
						<li><span>Northline commission (fixed)</span><strong data-part="0.08"></strong></li>
					</ul>
				</div>
			<?php endif; ?>
			<a class="btn btn--primary btn--block" href="#request">Request this car</a>
			<a class="btn btn--ghost btn--block" href="<?php echo esc_url( nl_content( 'company' )['whatsapp'] . '?text=' . rawurlencode( 'Hi, I am interested in ' . get_the_title() . ' ' . get_permalink() ) ); ?>" rel="noopener" target="_blank"><?php echo nl_icon( 'whatsapp' ); ?> Ask on WhatsApp</a>
			<ul class="pricebox__points">
				<li><?php echo nl_icon( 'check' ); ?> Auction sheet translated for you</li>
				<li><?php echo nl_icon( 'check' ); ?> Photos at every stage of shipping</li>
				<li><?php echo nl_icon( 'check' ); ?> Fixed fee agreed before bidding</li>
			</ul>
		</div>
	</aside>
</article>

<?php
$similar = NL_Query::query( [ 'make' => $make ? $make->slug : '' ], 5 );
$similar = array_values( array_filter( $similar->posts, static fn ( $p ) => $p->ID !== $id ) );
if ( $similar ) : ?>
<section class="section section--similar">
	<div class="container">
		<div class="section__head"><h2>Similar vehicles</h2><a class="link-arrow" href="<?php echo esc_url( $make ? get_term_link( $make ) : get_post_type_archive_link( 'vehicle' ) ); ?>">More <?php echo esc_html( $make ? $make->name : 'vehicles' ); ?> <?php echo nl_icon( 'arrow' ); ?></a></div>
		<div class="vehicle-grid">
			<?php foreach ( array_slice( $similar, 0, 4 ) as $p ) { echo nl_render_card( $p ); } ?>
		</div>
	</div>
</section>
<?php endif; ?>
<?php get_footer();
