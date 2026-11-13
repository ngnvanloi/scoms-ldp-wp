(function () {
	'use strict';

	var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var hasIO = 'IntersectionObserver' in window;

	var pending = [];
	var lastSweep = 0;

	function reveal(el) {
		el.classList.add('is-in');
		if (revealObserver) {
			revealObserver.unobserve(el);
		}
		var index = pending.indexOf(el);
		if (index > -1) {
			pending.splice(index, 1);
		}
	}

	var revealObserver = hasIO ? new IntersectionObserver(function (entries) {
		entries.forEach(function (entry) {
			if (entry.isIntersecting || entry.boundingClientRect.bottom < 0) {
				reveal(entry.target);
			}
		});
	}, { rootMargin: '0px 0px -12% 0px', threshold: 0.12 }) : null;

	function sweepPassed() {
		var now = Date.now();
		if (!pending.length || now - lastSweep < 150) {
			return;
		}
		lastSweep = now;
		pending.slice().forEach(function (el) {
			if (el.getBoundingClientRect().bottom < 0) {
				reveal(el);
			}
		});
	}

	var liveObserver = hasIO ? new IntersectionObserver(function (entries) {
		entries.forEach(function (entry) {
			entry.target.classList.toggle('is-live', entry.isIntersecting);
		});
	}, { rootMargin: '80px 0px' }) : null;

	var tracks = [];
	var ticking = false;

	function measure() {
		ticking = false;
		var vh = window.innerHeight;
		tracks.forEach(function (track) {
			if (!track.active) {
				return;
			}
			var rect = track.el.getBoundingClientRect();
			var start = vh * 0.62;
			var p = (start - rect.top) / Math.max(rect.height, 1);
			p = Math.min(1, Math.max(0, p));
			track.el.style.setProperty('--scl-p', p.toFixed(4));
			track.steps.forEach(function (step) {
				var r = step.getBoundingClientRect();
				step.classList.toggle('is-on', r.top + r.height / 2 < start);
			});
		});
	}

	function requestMeasure() {
		if (!ticking) {
			ticking = true;
			window.requestAnimationFrame(function () {
				measure();
				sweepPassed();
			});
		}
	}

	var trackObserver = hasIO ? new IntersectionObserver(function (entries) {
		entries.forEach(function (entry) {
			tracks.forEach(function (track) {
				if (track.el === entry.target) {
					track.active = entry.isIntersecting;
				}
			});
		});
		requestMeasure();
	}, { rootMargin: '20% 0px' }) : null;

	function initSection(section) {
		if (section.dataset.sclMotionReady) {
			return;
		}
		section.dataset.sclMotionReady = '1';

		section.querySelectorAll('[data-scl-live]').forEach(function (el) {
			if (liveObserver && !reduced) {
				liveObserver.observe(el);
			}
		});

		if (reduced || !hasIO) {
			section.querySelectorAll('[data-scl-progress]').forEach(function (el) {
				el.style.setProperty('--scl-p', '1');
				el.querySelectorAll('[data-scl-step]').forEach(function (step) {
					step.classList.add('is-on');
				});
			});
			return;
		}

		section.classList.add('is-ready');
		section.querySelectorAll('[data-scl-reveal]').forEach(function (el) {
			pending.push(el);
			revealObserver.observe(el);
		});

		section.querySelectorAll('[data-scl-progress]').forEach(function (el) {
			tracks.push({ el: el, steps: el.querySelectorAll('[data-scl-step]'), active: false });
			trackObserver.observe(el);
		});
	}

	function initAll(root) {
		var scope = root || document;
		if (scope.matches && scope.matches('[data-scl-motion]')) {
			initSection(scope);
		}
		scope.querySelectorAll('[data-scl-motion]').forEach(initSection);
	}

	function renderAllDeferred() {
		document.querySelectorAll('.scl-defer:not(.is-full)').forEach(function (section) {
			section.classList.add('is-full');
		});
	}

	document.addEventListener('click', function (event) {
		var link = event.target.closest ? event.target.closest('a[href^="#"]') : null;
		if (!link) {
			return;
		}
		var id = link.getAttribute('href').slice(1);
		if (id && document.getElementById(id)) {
			renderAllDeferred();
		}
	}, true);

	if (window.location.hash.length > 1) {
		var hashTarget = document.getElementById(window.location.hash.slice(1));
		if (hashTarget) {
			renderAllDeferred();
			window.requestAnimationFrame(function () {
				hashTarget.scrollIntoView();
			});
		}
	}

	window.addEventListener('scroll', requestMeasure, { passive: true });
	window.addEventListener('resize', requestMeasure, { passive: true });

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			initAll();
		});
	} else {
		initAll();
	}

	if (window.jQuery) {
		window.jQuery(window).on('elementor/frontend/init', function () {
			window.elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope) {
				initAll($scope[0]);
			});
		});
	}
})();
