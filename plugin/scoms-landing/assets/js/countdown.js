(function () {
	'use strict';

	function pad(n) {
		return n < 10 ? '0' + n : String(n);
	}

	function init(el) {
		if (el.dataset.sclReady) {
			return;
		}

		var target = Date.parse(el.getAttribute('data-scl-countdown'));
		if (isNaN(target)) {
			return;
		}
		el.dataset.sclReady = '1';

		var units = {};
		el.querySelectorAll('[data-unit]').forEach(function (node) {
			units[node.getAttribute('data-unit')] = node;
		});
		var done = el.querySelector('.scl-countdown__done');
		var timer = null;

		function set(key, value) {
			if (units[key]) {
				units[key].textContent = pad(value);
			}
		}

		function tick() {
			if (!el.isConnected) {
				clearInterval(timer);
				return;
			}

			var diff = Math.max(0, target - Date.now());
			var s = Math.floor(diff / 1000);

			set('days', Math.floor(s / 86400));
			set('hours', Math.floor((s % 86400) / 3600));
			set('minutes', Math.floor((s % 3600) / 60));
			set('seconds', s % 60);

			if (diff === 0) {
				el.setAttribute('data-ended', '');
				if (done) {
					done.hidden = false;
				}
				clearInterval(timer);
			}
		}

		tick();
		timer = setInterval(tick, 1000);
	}

	function initAll(root) {
		(root || document).querySelectorAll('[data-scl-countdown]').forEach(init);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			initAll();
		});
	} else {
		initAll();
	}

	if (window.jQuery) {
		window.jQuery(window).on('elementor/frontend/init', function () {
			window.elementorFrontend.hooks.addAction('frontend/element_ready/scl_hero.default', function ($scope) {
				initAll($scope[0]);
			});
		});
	}
})();
