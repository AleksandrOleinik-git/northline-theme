<?php
/**
 * Inventory filter form. $args['compact'] = true renders the short hero version.
 */
defined( 'ABSPATH' ) || exit;
$compact = ! empty( $args['compact'] );
[ $year_min, $year_max ]   = NL_Query::range( '_nl_year' );
[ $price_min, $price_max ] = NL_Query::range( '_nl_price_usd' );
$cur_make = nl_filter_value( 'make' );
?>
<form class="filters<?php echo $compact ? ' filters--compact' : ''; ?>" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'vehicle' ) ); ?>" data-filters>
	<div class="filters__grid">
		<label class="field"><span>Make</span>
			<select name="make" data-make>
				<option value="">Any make</option>
				<?php foreach ( NL_Query::terms( 'make' ) as $t ) : ?>
					<option value="<?php echo esc_attr( $t->slug ); ?>" <?php selected( $cur_make, $t->slug ); ?>><?php echo esc_html( $t->name ); ?> (<?php echo (int) $t->count; ?>)</option>
				<?php endforeach; ?>
			</select>
		</label>
		<label class="field"><span>Model</span>
			<select name="model" data-model <?php disabled( $cur_make === '' ); ?>>
				<option value="">Any model</option>
				<?php if ( $cur_make ) : foreach ( NL_Query::models_for_make( $cur_make ) as $m ) : ?>
					<option value="<?php echo esc_attr( $m ); ?>" <?php selected( nl_filter_value( 'model' ), $m ); ?>><?php echo esc_html( $m ); ?></option>
				<?php endforeach; endif; ?>
			</select>
		</label>
		<div class="field field--range"><span>Year</span>
			<div>
				<input type="number" name="year_min" placeholder="<?php echo (int) $year_min; ?>" min="<?php echo (int) $year_min; ?>" max="<?php echo (int) $year_max; ?>" value="<?php echo esc_attr( nl_filter_value( 'year_min' ) ); ?>" aria-label="Year from">
				<input type="number" name="year_max" placeholder="<?php echo (int) $year_max; ?>" min="<?php echo (int) $year_min; ?>" max="<?php echo (int) $year_max; ?>" value="<?php echo esc_attr( nl_filter_value( 'year_max' ) ); ?>" aria-label="Year to">
			</div>
		</div>
		<div class="field field--range"><span>Price, USD</span>
			<div>
				<input type="number" name="price_min" placeholder="<?php echo (int) $price_min; ?>" step="500" value="<?php echo esc_attr( nl_filter_value( 'price_min' ) ); ?>" aria-label="Price from">
				<input type="number" name="price_max" placeholder="<?php echo (int) $price_max; ?>" step="500" value="<?php echo esc_attr( nl_filter_value( 'price_max' ) ); ?>" aria-label="Price to">
			</div>
		</div>
		<?php if ( ! $compact ) : ?>
			<?php foreach ( [ 'body' => 'Body type', 'fuel' => 'Fuel', 'transmission' => 'Transmission', 'drive' => 'Drivetrain' ] as $tax => $label ) : ?>
				<label class="field"><span><?php echo esc_html( $label ); ?></span>
					<select name="<?php echo esc_attr( $tax ); ?>">
						<option value="">Any</option>
						<?php foreach ( NL_Query::terms( $tax ) as $t ) : ?>
							<option value="<?php echo esc_attr( $t->slug ); ?>" <?php selected( nl_filter_value( $tax ), $t->slug ); ?>><?php echo esc_html( $t->name ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			<?php endforeach; ?>
			<label class="field"><span>Max mileage, km</span>
				<select name="km_max">
					<option value="">Any</option>
					<?php foreach ( [ 10000, 30000, 50000, 80000, 100000, 150000 ] as $km ) : ?>
						<option value="<?php echo (int) $km; ?>" <?php selected( nl_filter_value( 'km_max' ), (string) $km ); ?>>up to <?php echo esc_html( number_format( $km ) ); ?></option>
					<?php endforeach; ?>
				</select>
			</label>
			<label class="field"><span>Keyword</span><input type="search" name="q" value="<?php echo esc_attr( nl_filter_value( 'q' ) ); ?>" placeholder="Alphard, Hiace, Jimny…"></label>
		<?php endif; ?>
	</div>
	<div class="filters__actions">
		<button class="btn btn--primary" type="submit"><?php echo nl_icon( 'search' ); ?> Show vehicles</button>
		<?php if ( ! $compact ) : ?><a class="btn btn--ghost" href="<?php echo esc_url( get_post_type_archive_link( 'vehicle' ) ); ?>">Reset</a><?php endif; ?>
	</div>
</form>
