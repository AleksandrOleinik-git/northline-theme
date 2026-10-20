/* Northline Motors theme: vanilla JS, no dependencies. */
(function () {
	'use strict';

	var $ = function (sel, root) { return (root || document).querySelector(sel); };
	var $$ = function (sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); };

	/* Mobile navigation */
	var toggle = $('.nav-toggle'), nav = $('#site-nav');
	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var open = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			document.body.classList.toggle('nav-open', open);
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && nav.classList.contains('is-open')) { toggle.click(); }
		});
	}

	/* Sticky header shadow */
	var header = $('.site-header');
	if (header) {
		var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 8); };
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}

	/* Dependent model select in filter forms */
	$$('[data-filters]').forEach(function (form) {
		var make = $('[data-make]', form), model = $('[data-model]', form);
		if (!make || !model) { return; }
		make.addEventListener('change', function () {
			model.innerHTML = '<option value="">Any model</option>';
			model.disabled = true;
			if (!make.value) { return; }
			fetch(nlTheme.rest + 'models?make=' + encodeURIComponent(make.value))
				.then(function (r) { return r.json(); })
				.then(function (list) {
					list.forEach(function (m) {
						var o = document.createElement('option');
						o.value = m; o.textContent = m; model.appendChild(o);
					});
					model.disabled = list.length === 0;
				})
				.catch(function () { model.disabled = true; });
		});
	});

	/* Collapsible filters on small screens */
	var ftoggle = $('[data-filters-toggle]');
	if (ftoggle) {
		var aside = ftoggle.closest('.inventory__filters');
		if (window.location.search.length > 1) { aside.classList.add('is-open'); ftoggle.setAttribute('aria-expanded', 'true'); }
		ftoggle.addEventListener('click', function () {
			var open = aside.classList.toggle('is-open');
			ftoggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	}

	/* Sort select on the inventory page: reload with ?sort= */
	var sort = $('[data-sort]');
	if (sort) {
		sort.addEventListener('change', function () {
			var url = new URL(window.location.href);
			url.searchParams.set('sort', sort.value);
			url.searchParams.delete('paged');
			window.location.href = url.toString();
		});
	}

	/* Load more via REST, keeps current filters */
	var more = $('[data-load-more]'), results = $('[data-results]');
	if (more && results) {
		more.addEventListener('click', function () {
			var page = parseInt(more.dataset.page, 10) + 1, pages = parseInt(more.dataset.pages, 10);
			var params = new URLSearchParams(window.location.search);
			params.set('paged', page);
			more.disabled = true; more.textContent = 'Loading…';
			fetch(nlTheme.rest + 'vehicles?' + params.toString())
				.then(function (r) { return r.json(); })
				.then(function (data) {
					data.items.forEach(function (item) { results.insertAdjacentHTML('beforeend', item.html); });
					more.dataset.page = page;
					if (page >= pages) { more.hidden = true; } else { more.disabled = false; more.textContent = 'Show more vehicles'; }
					var pag = $('.pagination'); if (pag) { pag.hidden = true; }
				})
				.catch(function () { more.disabled = false; more.textContent = 'Try again'; });
		});
	}

	/* Vehicle gallery */
	var gallery = $('[data-gallery]');
	if (gallery) {
		var stage = $('.gallery__img', gallery), thumbs = $$('.gallery__thumbs button', gallery), index = 0;
		var show = function (i) {
			if (!thumbs.length) { return; }
			index = (i + thumbs.length) % thumbs.length;
			stage.src = thumbs[index].dataset.full;
			stage.removeAttribute('srcset'); stage.removeAttribute('sizes');
			thumbs.forEach(function (b, n) { b.classList.toggle('is-active', n === index); });
		};
		thumbs.forEach(function (b) { b.addEventListener('click', function () { show(parseInt(b.dataset.index, 10)); }); });
		var prev = $('[data-prev]', gallery), next = $('[data-next]', gallery);
		if (prev) { prev.addEventListener('click', function () { show(index - 1); }); }
		if (next) { next.addEventListener('click', function () { show(index + 1); }); }
		document.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowLeft') { show(index - 1); }
			if (e.key === 'ArrowRight') { show(index + 1); }
		});
		var startX = null;
		gallery.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
		gallery.addEventListener('touchend', function (e) {
			if (startX === null) { return; }
			var dx = e.changedTouches[0].clientX - startX;
			if (Math.abs(dx) > 40) { show(dx < 0 ? index + 1 : index - 1); }
			startX = null;
		});
	}

	/* Price breakdown */
	var breakdown = $('[data-breakdown]');
	if (breakdown) {
		var total = parseInt(breakdown.dataset.price, 10), list = $('.breakdown__list', breakdown), btn = $('.breakdown__toggle', breakdown);
		$$('[data-part]', breakdown).forEach(function (el) {
			el.textContent = '$' + Math.round(total * parseFloat(el.dataset.part)).toLocaleString('en-US');
		});
		btn.addEventListener('click', function () {
			var open = list.hidden;
			list.hidden = !open;
			btn.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	}

	/* Lead forms: submit via fetch, fall back to normal POST */
	$$('.nl-lead-form').forEach(function (form) {
		form.addEventListener('submit', function (e) {
			if (!window.fetch || !window.FormData) { return; }
			e.preventDefault();
			var status = $('.nl-lead-form__status', form), button = $('button[type=submit]', form);
			button.disabled = true; status.textContent = 'Sending…'; status.className = 'nl-lead-form__status';
			fetch(form.dataset.ajax, { method: 'POST', body: new FormData(form), credentials: 'same-origin' })
				.then(function (r) { return r.json(); })
				.then(function (res) {
					if (res.success) {
						form.reset();
						status.textContent = res.data.message; status.classList.add('is-success');
					} else {
						status.textContent = res.data.message || 'Something went wrong.'; status.classList.add('is-error');
					}
				})
				.catch(function () { status.textContent = 'Network error, please try again.'; status.classList.add('is-error'); })
				.then(function () { button.disabled = false; });
		});
	});
})();
