<?php
/**
 * Template Name: Contact
 */
get_header();
the_post();
$c = nl_content( 'company' );
?>
<section class="page-head"><div class="container"><nav class="breadcrumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> <span>/</span> <span aria-current="page"><?php the_title(); ?></span></nav><h1><?php the_title(); ?></h1></div></section>
<section class="section"><div class="container contact">
	<div class="contact__info">
		<h2>Office</h2>
		<p><?php echo esc_html( $c['address'] ); ?><br><?php echo esc_html( $c['city'] ); ?></p>
		<p><a href="tel:<?php echo esc_attr( $c['phone_href'] ); ?>"><?php echo esc_html( $c['phone'] ); ?></a><br><a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a></p>
		<p><?php echo esc_html( $c['hours'] ); ?></p>
		<p><a class="btn btn--ghost" href="<?php echo esc_url( $c['whatsapp'] ); ?>" rel="noopener" target="_blank"><?php echo nl_icon( 'whatsapp' ); ?> Chat on WhatsApp</a></p>
		<?php if ( get_the_content() ) : ?><div class="prose"><?php the_content(); ?></div><?php endif; ?>
	</div>
	<div class="contact__map"><iframe title="Office map" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen src="https://www.google.com/maps?q=1188+West+Pender+St,+Vancouver,+BC&amp;z=15&amp;hl=en&amp;output=embed"></iframe></div>
</div></section>
<?php get_footer();
