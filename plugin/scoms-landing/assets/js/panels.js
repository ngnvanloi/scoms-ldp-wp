(function () {
	'use strict';

	function activate(root, index, focus) {
		var tabs = root.querySelectorAll('[data-scl-panel-tab]');
		var panels = root.querySelectorAll('[data-scl-panel]');
		tabs.forEach(function (tab, i) {
			var on = i === index;
			tab.setAttribute('aria-expanded', on ? 'true' : 'false');
			panels[i].classList.toggle('is-active', on);
			if (on && focus) {
				tab.focus();
			}
		});
	}

	function init(root) {
		if (root.dataset.sclPanelsReady) {
			return;
		}
		root.dataset.sclPanelsReady = '1';
		var tabs = Array.prototype.slice.call(root.querySelectorAll('[data-scl-panel-tab]'));

		tabs.forEach(function (tab, i) {
			tab.addEventListener('click', function () {
				activate(root, i, false);
			});
			tab.addEventListener('keydown', function (event) {
				var next = null;
				if (event.key === 'ArrowRight' || event.key === 'ArrowDown') {
					next = (i + 1) % tabs.length;
				} else if (event.key === 'ArrowLeft' || event.key === 'ArrowUp') {
					next = (i - 1 + tabs.length) % tabs.length;
				} else if (event.key === 'Home') {
					next = 0;
				} else if (event.key === 'End') {
					next = tabs.length - 1;
				}
				if (next !== null) {
					event.preventDefault();
					activate(root, next, true);
				}
			});
		});
	}

	function initAll(scope) {
		(scope || document).querySelectorAll('[data-scl-panels]').forEach(init);
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
			window.elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope) {
				initAll($scope[0]);
			});
		});
	}
})();
