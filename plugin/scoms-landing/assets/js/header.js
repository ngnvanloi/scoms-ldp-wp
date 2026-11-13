(function () {
	'use strict';

	function init(header) {
		if (header.dataset.sclHeaderReady) {
			return;
		}
		header.dataset.sclHeaderReady = '1';

		var toggle = header.querySelector('.scl-hd__toggle');
		var links = Array.prototype.slice.call(header.querySelectorAll('.scl-hd__link'));
		var lastY = window.scrollY;
		var ticking = false;

		function setOpen(open) {
			header.classList.toggle('is-open', open);
			if (toggle) {
				toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			}
			if (open) {
				header.classList.remove('is-hidden');
			}
		}

		if (toggle) {
			toggle.addEventListener('click', function () {
				setOpen(!header.classList.contains('is-open'));
			});
		}

		links.forEach(function (link) {
			link.addEventListener('click', function () {
				setOpen(false);
			});
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && header.classList.contains('is-open')) {
				setOpen(false);
				if (toggle) {
					toggle.focus();
				}
			}
		});

		function onScroll() {
			ticking = false;
			var y = window.scrollY;
			header.classList.toggle('is-scrolled', y > 8);
			if (!header.classList.contains('is-open') && !header.contains(document.activeElement)) {
				if (y > lastY + 6 && y > 160) {
					header.classList.add('is-hidden');
				} else if (y < lastY - 6) {
					header.classList.remove('is-hidden');
				}
			}
			lastY = y;
		}

		window.addEventListener('scroll', function () {
			if (!ticking) {
				ticking = true;
				window.requestAnimationFrame(onScroll);
			}
		}, { passive: true });
		onScroll();

		if (!('IntersectionObserver' in window)) {
			return;
		}
		var targets = links.map(function (link) {
			var id = (link.getAttribute('href') || '').replace('#', '');
			return id ? document.getElementById(id) : null;
		});
		var visible = {};
		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				visible[entry.target.id] = entry.isIntersecting;
			});
			var current = null;
			targets.forEach(function (target) {
				if (target && !current && visible[target.id]) {
					current = target.id;
				}
			});
			links.forEach(function (link, i) {
				link.setAttribute('aria-current', targets[i] && targets[i].id === current ? 'true' : 'false');
			});
		}, { rootMargin: '-40% 0px -55% 0px' });
		targets.forEach(function (target) {
			if (target) {
				observer.observe(target);
			}
		});
	}

	function initAll(scope) {
		(scope || document).querySelectorAll('[data-scl-header]').forEach(init);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			initAll();
		});
	} else {
		initAll();
	}
})();
