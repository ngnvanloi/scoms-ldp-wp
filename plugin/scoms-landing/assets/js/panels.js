(function () {
	'use strict';

	function init(root) {
		if (root.dataset.sclPanelsReady) {
			return;
		}
		root.dataset.sclPanelsReady = '1';
		var tabs = Array.prototype.slice.call(root.querySelectorAll('[data-scl-panel-tab]'));
		var panels = Array.prototype.slice.call(root.querySelectorAll('[data-scl-panel]'));

		function activate(index, moveFocus) {
			panels.forEach(function (panel, i) {
				var on = i === index;
				panel.classList.toggle('is-active', on);
				tabs[i].setAttribute('aria-expanded', on ? 'true' : 'false');
			});
			if (moveFocus) {
				var body = panels[index].querySelector('.scl-hl__body');
				if (body) {
					body.focus({ preventScroll: true });
				}
			}
		}

		function visibleTabs() {
			return tabs.filter(function (tab, i) {
				return !panels[i].classList.contains('is-active');
			});
		}

		tabs.forEach(function (tab, i) {
			tab.addEventListener('click', function (event) {
				activate(i, event.detail === 0);
			});
			tab.addEventListener('keydown', function (event) {
				var list = visibleTabs();
				var at = list.indexOf(tab);
				var next = null;
				if (event.key === 'ArrowDown' || event.key === 'ArrowRight') {
					next = list[(at + 1) % list.length];
				} else if (event.key === 'ArrowUp' || event.key === 'ArrowLeft') {
					next = list[(at - 1 + list.length) % list.length];
				} else if (event.key === 'Home') {
					next = list[0];
				} else if (event.key === 'End') {
					next = list[list.length - 1];
				}
				if (next) {
					event.preventDefault();
					next.focus();
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
