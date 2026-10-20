<?php
/**
 * Static site content (company data, advantages, process steps, FAQ, reviews).
 * Kept in one place so a client can edit texts without touching templates.
 * Every block is filterable: add_filter( 'northline_content_faq', ... ).
 */
defined( 'ABSPATH' ) || exit;

function nl_content( string $block ): array {
	static $content = null;
	if ( $content === null ) {
		$content = [
			'company' => [
				'name'         => 'Northline Motors',
				'tagline'      => 'Japanese & Korean cars, bought at auction, delivered to your port',
				'phone'        => '+1 (604) 555-0142',
				'phone_href'   => '+16045550142',
				'whatsapp'     => 'https://wa.me/16045550142',
				'email'        => 'sales@northline.example',
				'address'      => '1188 West Pender St, Suite 400',
				'city'         => 'Vancouver, BC V6E 4A2',
				'country'      => 'CA',
				'hours'        => 'Mon–Fri 9:00–18:00, Sat 10:00–15:00 (PT)',
				'hours_schema' => [ 'Mo-Fr 09:00-18:00', 'Sa 10:00-15:00' ],
				'social'       => [ 'instagram' => 'https://instagram.com/', 'youtube' => 'https://youtube.com/', 'facebook' => 'https://facebook.com/' ],
				'since'        => 2001,
			],
			'hero' => [
				'title'    => 'Cars from Japanese auctions, delivered to your door',
				'subtitle' => 'Over 70,000 vehicles are listed at Japanese auctions every week. We inspect, bid, ship and clear customs for you, at a fixed fee with no hidden charges.',
				'cta'      => 'Get a landed-cost quote',
				'stats'    => [ [ '70,000+', 'auction lots every week' ], [ '3,400+', 'cars delivered since 2001' ], [ '4.9', 'average customer rating' ] ],
			],
			'advantages' => [
				[ 'shield',   'Customs clearance included', 'We handle import paperwork, bonded warehouse pickup and compliance inspection, so the car arrives ready to register.' ],
				[ 'clock',    'Managers available 7 days a week', 'Phone, WhatsApp or email, in your time zone. Your manager stays with you from the first quote to the keys in your hand.' ],
				[ 'tag',      'Fixed fee, no surprises', 'Our commission is a flat fee agreed before bidding. The auction price, shipping and duties are passed through at cost with receipts.' ],
				[ 'ship',     'Sea freight on your schedule', 'RoRo or container shipping from Yokohama, Osaka and Busan to major ports in North America, Europe, Africa and Oceania.' ],
				[ 'wallet',   'Pay in three steps', 'A deposit to start bidding, the car price after we win, and duties on arrival. Every payment is tied to a document you can verify.' ],
				[ 'calendar', 'Pick up any day', 'Collect your vehicle from our yard on any working day, or let us deliver it by truck to your city.' ],
			],
			'process' => [
				[ 'Tell us what you want', 'Send a request with the make, model, year, budget and destination port. We reply with real auction examples and a landed-cost estimate within 24 hours.' ],
				[ 'Pick the car, check the auction sheet', 'We translate the inspection sheet, grade and photos for each candidate and advise honestly, even if it means waiting for a better lot.' ],
				[ 'Sign the contract and pay the deposit', 'A simple contract fixes our fee and the maximum bid. The deposit is refundable if we do not win the lot.' ],
				[ 'We bid, buy and ship', 'After a successful bid you pay the car price. We handle export deregistration, inland transport, loading and sea freight, and send you photos at every step.' ],
				[ 'Receive the car', 'We clear customs at your port and hand over the car with all documents, or arrange onward delivery to your city.' ],
			],
			'faq' => [
				[ 'Why buy through an importer instead of flying to Japan myself?', 'Japanese auctions are dealer-only: you need a licensed member to bid. We also read auction sheets in Japanese, know which auction houses grade strictly, and have export, shipping and customs set up. You pay a fixed fee and save weeks of work and most of the risk.' ],
				[ 'What does the fixed fee cover?', 'Auction bidding, inspection sheet translation, export deregistration, inland transport to the port, export documents and our support until the car is handed over. Shipping, insurance and import duties are passed through at cost.' ],
				[ 'Can I cancel after I pay the deposit?', 'Yes, before we place a bid, the deposit is fully refundable. After a winning bid the purchase is binding, because the auction house charges us the full price.' ],
				[ 'What if the car arrives damaged?', 'Every car is photographed at the auction, at loading and at unloading. Sea freight is insured; if transport damage is found at the port, the insurance claim is filed by us and you receive the compensation.' ],
				[ 'How long does delivery take?', 'Typically 6–10 weeks from a winning bid to the car at your port: 1–2 weeks for export paperwork and inland transport, 3–6 weeks at sea, and up to a week for customs.' ],
				[ 'Which ports do you ship to?', 'Vancouver, Halifax, Tacoma, Los Angeles, Rotterdam, Southampton, Auckland, Sydney, Mombasa and Dar es Salaam on a regular basis. Other ports on request.' ],
			],
			'reviews' => [
				[ 'Daniel K.', 'Vancouver', 5, '2019 Toyota Alphard', 'Got my Alphard in 8 weeks exactly as promised. The auction sheet translation was spot on, the car had zero surprises. Fixed fee meant I knew the final number before bidding.' ],
				[ 'Sarah M.', 'Auckland', 5, '2016 Honda Fit Hybrid', 'Second car through Northline. They talked me out of a lot that looked good on photos but had a repaired frame on the sheet. That honesty is why I came back.' ],
				[ 'Olufemi A.', 'Lagos', 5, '2018 Toyota Hiace', 'Documentation was perfect, customs took three days. The manager answered WhatsApp at midnight his time. Highly recommended for commercial vans.' ],
				[ 'Tom R.', 'Rotterdam', 4, '2015 Suzuki Jimny', 'Shipping took a bit longer than estimated because of a port strike, but they kept me updated every few days and the car itself was flawless.' ],
			],
			'rating_sources' => [ [ 'Google', '4.9', '312' ], [ 'Trustpilot', '4.8', '184' ], [ 'Facebook', '5.0', '96' ] ],
		];
	}
	return apply_filters( 'northline_content_' . $block, $content[ $block ] ?? [] );
}
