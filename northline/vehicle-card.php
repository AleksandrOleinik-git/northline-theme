<?php
/**
 * Vehicle card. $post is set by nl_render_card().
 * @var WP_Post $post
 */
defined( 'ABSPATH' ) || exit;
$id     = $post->ID;
$status = nl_vehicle_term( $id, 'status' );
$grade  = nl_vehicle_meta( $id, 'grade' );
$slug   = $status ? sanitize_title( $status ) : '';
?>
<article class="vehicle-card<?php echo $slug === 'sold' ? ' is-sold' : ''; ?>">
	<a class="vehicle-card__media" href="<?php echo esc_url( get_permalink( $id ) ); ?>" tabindex="-1" aria-hidden="true">
		<?php echo get_the_post_thumbnail( $id, 'nl-card', [ 'loading' => 'lazy', 'decoding' => 'async' ] ) ?: '<span class="vehicle-card__placeholder">' . nl_icon( 'car' ) . '</span>'; ?>
		<?php if ( $status ) : ?><span class="badge badge--<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $status ); ?></span><?php endif; ?>
		<?php if ( $grade !== '' ) : ?><span class="vehicle-card__grade" title="Auction grade">Grade <?php echo esc_html( $grade ); ?></span><?php endif; ?>
	</a>
	<div class="vehicle-card__body">
		<h3 class="vehicle-card__title"><a href="<?php echo esc_url( get_permalink( $id ) ); ?>"><?php echo esc_html( get_the_title( $id ) ); ?></a></h3>
		<ul class="vehicle-card__specs">
			<?php if ( nl_vehicle_meta( $id, 'year' ) !== '' ) : ?><li><?php echo nl_icon( 'calendar' ); ?><?php echo esc_html( nl_vehicle_meta( $id, 'year' ) ); ?></li><?php endif; ?>
			<?php if ( nl_vehicle_meta( $id, 'mileage_km' ) !== '' ) : ?><li><?php echo nl_icon( 'gauge' ); ?><?php echo esc_html( nl_format_km( nl_vehicle_meta( $id, 'mileage_km' ) ) ); ?></li><?php endif; ?>
			<?php if ( nl_vehicle_meta( $id, 'engine_cc' ) !== '' ) : ?><li><?php echo nl_icon( 'engine' ); ?><?php echo esc_html( number_format( (float) nl_vehicle_meta( $id, 'engine_cc' ), 0, '.', ',' ) ); ?> cc</li><?php endif; ?>
			<?php if ( nl_vehicle_term( $id, 'transmission' ) ) : ?><li><?php echo nl_icon( 'gear' ); ?><?php echo esc_html( nl_vehicle_term( $id, 'transmission' ) ); ?></li><?php endif; ?>
		</ul>
		<div class="vehicle-card__foot">
			<span class="vehicle-card__price"><?php echo esc_html( nl_format_price( nl_vehicle_meta( $id, 'price_usd' ) ) ); ?></span>
			<span class="vehicle-card__stock">#<?php echo esc_html( nl_vehicle_meta( $id, 'stock_no' ) ?: $id ); ?></span>
		</div>
	</div>
</article>
