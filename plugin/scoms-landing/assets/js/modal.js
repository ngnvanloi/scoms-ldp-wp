(function () {
	'use strict';

	function bindDialog(dialog) {
		if (dialog.dataset.sclDialogReady) {
			return;
		}
		dialog.dataset.sclDialogReady = '1';

		dialog.addEventListener('click', function (event) {
			if (event.target === dialog) {
				dialog.close();
			}
		});

		dialog.querySelectorAll('[data-scl-dialog-close]').forEach(function (button) {
			button.addEventListener('click', function () {
				dialog.close();
			});
		});
	}

	function bindOpener(button) {
		if (button.dataset.sclOpenerReady) {
			return;
		}
		button.dataset.sclOpenerReady = '1';

		button.addEventListener('click', function () {
			var dialog = document.getElementById(button.getAttribute('data-scl-dialog-open'));
			if (!dialog || typeof dialog.showModal !== 'function') {
				return;
			}
			bindDialog(dialog);
			var body = dialog.querySelector('.scl-modal__body');
			if (body) {
				body.scrollTop = 0;
			}
			dialog.showModal();
		});
	}

	function initAll(scope) {
		var root = scope || document;
		root.querySelectorAll('[data-scl-dialog-open]').forEach(bindOpener);
		root.querySelectorAll('dialog.scl-modal').forEach(bindDialog);
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
