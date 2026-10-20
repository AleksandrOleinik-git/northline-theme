<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); $c = nl_content( 'company' ); ?>
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header" id="top">
	<div class="site-header__bar">
		<div class="container site-header__bar-inner">
			<span class="site-header__tagline"><?php echo esc_html( $c['tagline'] ); ?></span>
			<span class="site-header__contacts">
				<a href="<?php echo esc_url( $c['whatsapp'] ); ?>" rel="noopener" target="_blank"><?php echo nl_icon( 'whatsapp' ); ?> WhatsApp</a>
				<a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo nl_icon( 'mail' ); ?> <?php echo esc_html( $c['email'] ); ?></a>
			</span>
		</div>
	</div>
	<div class="container site-header__main">
		<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
				<span class="site-logo__mark"><?php echo nl_icon( 'logo' ); ?></span><span class="site-logo__text">Northline<em>Motors</em></span>
			<?php endif; ?>
		</a>
		<nav class="site-nav" id="site-nav" aria-label="Primary">
			<?php wp_nav_menu( [ 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'site-nav__list', 'fallback_cb' => 'nl_default_menu', 'depth' => 2 ] ); ?>
		</nav>
		<div class="site-header__actions">
			<a class="site-header__phone" href="tel:<?php echo esc_attr( $c['phone_href'] ); ?>"><?php echo nl_icon( 'phone' ); ?><span><?php echo esc_html( $c['phone'] ); ?></span></a>
			<a class="btn btn--primary btn--sm" href="#request">Get a quote</a>
			<button class="nav-toggle" type="button" aria-controls="site-nav" aria-expanded="false" aria-label="Menu"><span></span></button>
		</div>
	</div>
</header>
<main id="main" class="site-main">
