<?php
/**
 * Front page.
 */
get_header();
$hero  = nl_content( 'hero' );
$c     = nl_content( 'company' );
$count = (int) wp_count_posts( 'vehicle' )->publish;
?>
<section class="hero">
	<div class="hero__bg" aria-hidden="true"></div>
	<div class="container hero__inner">
		<div class="hero__text">
			<p class="eyebrow">Licensed Japanese auction member since <?php echo (int) $c['since']; ?></p>
			<h1><?php echo esc_html( $hero['title'] ); ?></h1>
			<p class="hero__subtitle"><?php echo esc_html( $hero['subtitle'] ); ?></p>
			<div class="hero__actions">
				<a class="btn btn--primary btn--lg" href="#request"><?php echo esc_html( $hero['cta'] ); ?></a>
				<a class="btn btn--ghost btn--lg btn--light" href="<?php echo esc_url( get_post_type_archive_link( 'vehicle' ) ); ?>">Browse <?php echo (int) $count; ?> cars in stock</a>
			</div>
			<ul class="hero__stats">
				<?php foreach ( $hero['stats'] as [ $num, $label ] ) : ?>
					<li><strong><?php echo esc_html( $num ); ?></strong><span><?php echo esc_html( $label ); ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="hero__search">
			<h2>Find your car</h2>
			<?php get_template_part( 'template-parts/filters', null, [ 'compact' => true ] ); ?>
		</div>
	</div>
</section>

<section class="section section--featured">
	<div class="container">
		<div class="section__head">
			<h2>Arriving soon and in stock</h2>
			<a class="link-arrow" href="<?php echo esc_url( get_post_type_archive_link( 'vehicle' ) ); ?>">All vehicles <?php echo nl_icon( 'arrow' ); ?></a>
		</div>
		<div class="vehicle-grid">
			<?php
			// Random selection, one card per model, so the grid shows variety.
			$q    = new WP_Query( NL_Query::args( [ 'status' => 'in-stock,in-transit' ], 40 ) + [ 'orderby' => 'rand' ] );
			$seen = [];
			foreach ( $q->posts as $p ) {
				$model = nl_vehicle_term( $p->ID, 'make' ) . ' ' . nl_vehicle_meta( $p->ID, 'model' );
				if ( isset( $seen[ $model ] ) || count( $seen ) >= 8 ) {
					continue;
				}
				$seen[ $model ] = true;
				echo nl_render_card( $p );
			}
			?>
		</div>
	</div>
</section>

<section class="section section--advantages">
	<div class="container">
		<h2 class="section__title">Why buy through Northline</h2>
		<div class="advantages">
			<?php foreach ( nl_content( 'advantages' ) as [ $icon, $title, $text ] ) : ?>
				<div class="advantage"><?php echo nl_icon( $icon, 'advantage__icon' ); ?><h3><?php echo esc_html( $title ); ?></h3><p><?php echo esc_html( $text ); ?></p></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--process" id="how-it-works">
	<div class="container">
		<h2 class="section__title">How it works</h2>
		<ol class="process">
			<?php foreach ( nl_content( 'process' ) as $i => [ $title, $text ] ) : ?>
				<li class="process__step"><span class="process__num"><?php echo (int) $i + 1; ?></span><h3><?php echo esc_html( $title ); ?></h3><p><?php echo esc_html( $text ); ?></p></li>
			<?php endforeach; ?>
		</ol>
		<p class="section__cta"><a class="btn btn--primary" href="#request">Get a consultation</a> <a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/how-it-works/' ) ); ?>">Read the full guide</a></p>
	</div>
</section>

<section class="section section--reviews">
	<div class="container">
		<div class="section__head">
			<h2>What customers say</h2>
			<ul class="rating-sources">
				<?php foreach ( nl_content( 'rating_sources' ) as [ $src, $rating, $n ] ) : ?>
					<li><strong><?php echo esc_html( $rating ); ?></strong> <?php echo nl_icon( 'star' ); ?> <span><?php echo esc_html( $src ); ?>, <?php echo esc_html( $n ); ?> reviews</span></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="reviews">
			<?php foreach ( nl_content( 'reviews' ) as [ $name, $city, $stars, $car, $text ] ) : ?>
				<blockquote class="review">
					<p class="review__stars" aria-label="<?php echo (int) $stars; ?> out of 5"><?php echo str_repeat( nl_icon( 'star' ), $stars ); ?></p>
					<p><?php echo esc_html( $text ); ?></p>
					<footer><strong><?php echo esc_html( $name ); ?></strong>, <?php echo esc_html( $city ); ?> · <?php echo esc_html( $car ); ?></footer>
				</blockquote>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--faq">
	<div class="container container--narrow">
		<h2 class="section__title">Popular questions</h2>
		<?php get_template_part( 'template-parts/faq', null, [ 'limit' => 4 ] ); ?>
		<p class="section__cta"><a class="link-arrow" href="<?php echo esc_url( home_url( '/faq/' ) ); ?>">All questions and answers <?php echo nl_icon( 'arrow' ); ?></a></p>
	</div>
</section>

<?php
$posts = get_posts( [ 'posts_per_page' => 3 ] );
if ( $posts ) : ?>
<section class="section section--blog">
	<div class="container">
		<div class="section__head"><h2>Good to know</h2><a class="link-arrow" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Blog <?php echo nl_icon( 'arrow' ); ?></a></div>
		<div class="post-grid">
			<?php foreach ( $posts as $p ) : ?>
				<?php get_template_part( 'template-parts/post-card', null, [ 'post' => $p ] ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>
<?php get_footer();
