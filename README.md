# Northline Motors theme

A fast, dependency-free WordPress theme for car dealers and vehicle importers. Companion to the [Northline Inventory](https://github.com/AleksandrOleinik-git/northline-inventory) plugin.

**Live demo:** https://northline.clientus.vip

## What's inside

- Front page: hero with inventory search, featured vehicles, advantages, how-it-works steps, reviews, FAQ with `FAQPage` schema, blog teasers.
- Inventory archive with sidebar filters, dependent make → model select, sort, pagination and REST-powered "load more".
- Vehicle page: gallery with keyboard and swipe navigation, spec table, equipment list, price box with cost breakdown, request form, similar vehicles, `Vehicle` + `Offer` schema.
- Page templates: How it works, FAQ, Reviews, Contact (OpenStreetMap embed), plus blog index and single post.
- `AutoDealer` organisation schema on every page.
- One CSS file on custom properties, one vanilla JS file (≈5 KB), SVG icon sprite, system-friendly font loading. Lighthouse-friendly: lazy images, deferred script, no jQuery on the front end.
- Site texts (company data, advantages, steps, FAQ, reviews) live in `inc/content.php` and are filterable, so a client can edit them without touching templates.

## Requirements

WordPress 6.4+, PHP 8.0+, Northline Inventory plugin for the vehicle features (the theme degrades gracefully without it).

## License

GPL-2.0-or-later.
