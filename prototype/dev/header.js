(function () {
	'use strict';

	function init(header) {
		if (header.dataset.sclHeaderReady) {
			return;
		}
		header.dataset.sclHeaderReady = '1';

		var toggle = header.querySelector('.scl-hd__toggle');
		var parents = Array.prototype.slice.call(header.querySelectorAll('[data-scl-sub-toggle]'));
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

		function closeSubs(except) {
			parents.forEach(function (button) {
				if (button !== except) {
					button.setAttribute('aria-expanded', 'false');
					button.parentNode.classList.remove('is-sub-open');
				}
			});
		}

		if (toggle) {
			toggle.addEventListener('click', function () {
				setOpen(!header.classList.contains('is-open'));
			});
		}

		parents.forEach(function (button) {
			button.addEventListener('click', function () {
				var open = button.getAttribute('aria-expanded') !== 'true';
				closeSubs(button);
				button.setAttribute('aria-expanded', open ? 'true' : 'false');
				button.parentNode.classList.toggle('is-sub-open', open);
			});
		});

		document.addEventListener('click', function (event) {
			if (!header.contains(event.target)) {
				closeSubs(null);
			}
		});

		document.addEventListener('keydown', function (event) {
			if (event.key !== 'Escape') {
				return;
			}
			closeSubs(null);
			if (header.classList.contains('is-open')) {
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
