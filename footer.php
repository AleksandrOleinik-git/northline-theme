</main>
<?php $c = nl_content( 'company' ); ?>
<section class="cta-band" id="request">
	<div class="container cta-band__inner">
		<div class="cta-band__text">
			<h2>Tell us what you are looking for</h2>
			<p>Make, model, year, budget and your port. We reply within 24 hours with real auction examples and a landed-cost estimate.</p>
			<ul class="cta-band__points">
				<li><?php echo nl_icon( 'check' ); ?> No obligation, no fees for the quote</li>
				<li><?php echo nl_icon( 'check' ); ?> Fixed commission agreed before bidding</li>
				<li><?php echo nl_icon( 'check' ); ?> Managers reply on WhatsApp in your time zone</li>
			</ul>
		</div>
		<div class="cta-band__form">
			<?php if ( isset( $_GET['sent'] ) ) : ?>
				<div class="form-success"><?php echo nl_icon( 'check' ); ?><p><strong>Thank you!</strong> Your request is in. A manager will contact you shortly.</p></div>
			<?php else : ?>
				<?php echo class_exists( 'NL_Leads' ) ? NL_Leads::form( is_singular( 'vehicle' ) ? get_the_ID() : 0, 'Request a quote' ) : ''; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
<footer class="site-footer">
	<div class="container site-footer__grid">
		<div class="site-footer__about">
			<a class="site-logo site-logo--light" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="site-logo__mark"><?php echo nl_icon( 'logo' ); ?></span><span class="site-logo__text">Northline<em>Motors</em></span></a>
			<p>Licensed auction member and vehicle exporter since <?php echo (int) $c['since']; ?>. Japanese and Korean cars, vans, trucks and motorcycles delivered worldwide.</p>
			<p class="site-footer__social">
				<?php foreach ( $c['social'] as $name => $url ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" rel="noopener" target="_blank" aria-label="<?php echo esc_attr( ucfirst( $name ) ); ?>"><?php echo nl_icon( $name ); ?></a>
				<?php endforeach; ?>
			</p>
		</div>
		<nav class="site-footer__nav" aria-label="Footer">
			<h3>Inventory</h3>
			<ul>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'vehicle' ) ); ?>">All vehicles</a></li>
				<?php foreach ( array_slice( class_exists( 'NL_Query' ) ? NL_Query::terms( 'body' ) : [], 0, 6 ) as $t ) : ?>
					<li><a href="<?php echo esc_url( get_term_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</nav>
		<nav class="site-footer__nav" aria-label="Company">
			<h3>Company</h3>
			<?php wp_nav_menu( [ 'theme_location' => 'footer', 'container' => false, 'fallback_cb' => 'nl_default_menu', 'depth' => 1 ] ); ?>
		</nav>
		<div class="site-footer__contact">
			<h3>Contact</h3>
			<p><a href="tel:<?php echo esc_attr( $c['phone_href'] ); ?>"><?php echo esc_html( $c['phone'] ); ?></a><br><a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a></p>
			<p><?php echo esc_html( $c['address'] ); ?><br><?php echo esc_html( $c['city'] ); ?></p>
			<p><?php echo esc_html( $c['hours'] ); ?></p>
		</div>
	</div>
	<div class="container site-footer__bottom">
		<span>© <?php echo (int) gmdate( 'Y' ); ?> <?php echo esc_html( $c['name'] ); ?>. Demo website, all data is illustrative.</span>
		<a href="<?php echo esc_url( get_privacy_policy_url() ?: '#' ); ?>">Privacy policy</a>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
