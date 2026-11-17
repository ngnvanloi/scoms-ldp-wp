(function () {
	'use strict';

	var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var CLEANUP_MS = 900;

	function pad(n) {
		return n < 10 ? '0' + n : String(n);
	}

	function Tile(el) {
		this.el = el;
		this.box = el.querySelector('.scl-flip__digits');
		this.current = this.box.querySelector('.scl-flip__num');
		this.value = this.current ? this.current.textContent : '';
		this.leaving = null;
		this.timer = 0;
	}

	Tile.prototype.clearLeaving = function () {
		if (this.leaving && this.leaving.parentNode) {
			this.leaving.parentNode.removeChild(this.leaving);
		}
		this.leaving = null;
	};

	Tile.prototype.set = function (value, animate) {
		if (value === this.value) {
			return;
		}
		var tile = this;
		this.value = value;
		window.clearTimeout(this.timer);
		this.clearLeaving();

		if (!animate) {
			this.current.classList.remove('is-entering');
			this.current.textContent = value;
			return;
		}

		var next = document.createElement('span');
		next.className = 'scl-flip__num is-entering';
		next.textContent = value;

		this.leaving = this.current;
		this.leaving.classList.remove('is-entering');
		this.leaving.classList.add('is-leaving');
		this.box.appendChild(next);
		this.current = next;

		this.el.classList.remove('is-ticking');
		void this.el.offsetWidth;
		this.el.classList.add('is-ticking');

		this.timer = window.setTimeout(function () {
			tile.clearLeaving();
			next.classList.remove('is-entering');
			tile.el.classList.remove('is-ticking');
		}, CLEANUP_MS);
	};

	function parseTargets(root) {
		return [root.getAttribute('data-scl-flipclock'), root.getAttribute('data-scl-flipclock-extend')]
			.map(function (value) {
				return value ? Date.parse(value) : NaN;
			})
			.filter(function (time) {
				return !isNaN(time);
			})
			.sort(function (a, b) {
				return a - b;
			});
	}

	function init(root) {
		if (root.dataset.sclFlipReady) {
			return;
		}
		var targets = parseTargets(root);
		if (!targets.length) {
			return;
		}
		root.dataset.sclFlipReady = '1';

		var tiles = {};
		root.querySelectorAll('[data-flip-unit]').forEach(function (el) {
			tiles[el.getAttribute('data-flip-unit')] = new Tile(el);
		});
		var visible = true;
		var timer = 0;

		if ('IntersectionObserver' in window) {
			new IntersectionObserver(function (entries) {
				visible = entries[0].isIntersecting;
			}).observe(root);
		}

		function render(animate) {
			if (!root.isConnected) {
				window.clearTimeout(timer);
				return false;
			}
			var now = Date.now();
			var target = targets[targets.length - 1];
			for (var i = 0; i < targets.length; i++) {
				if (targets[i] > now) {
					target = targets[i];
					break;
				}
			}
			var diff = Math.max(0, target - now);
			var s = Math.floor(diff / 1000);
			var values = {
				days: pad(Math.floor(s / 86400)),
				hours: pad(Math.floor((s % 86400) / 3600)),
				minutes: pad(Math.floor((s % 3600) / 60)),
				seconds: pad(s % 60)
			};
			var motion = animate && visible && !reduced && !document.hidden;
			Object.keys(values).forEach(function (unit) {
				if (tiles[unit]) {
					tiles[unit].set(values[unit], motion);
				}
			});
			if (diff === 0) {
				root.setAttribute('data-ended', '');
				return false;
			}
			return true;
		}

		function loop() {
			if (render(true)) {
				timer = window.setTimeout(loop, 1000 - (Date.now() % 1000) + 10);
			}
		}

		if (render(false)) {
			timer = window.setTimeout(loop, 1000 - (Date.now() % 1000) + 10);
		}
	}

	function hideExpired(scope) {
		var now = Date.now();
		var nextCheck = Infinity;
		scope.querySelectorAll('[data-scl-until]').forEach(function (el) {
			var until = Date.parse(el.getAttribute('data-scl-until'));
			if (isNaN(until)) {
				return;
			}
			if (until <= now) {
				el.hidden = true;
			} else {
				nextCheck = Math.min(nextCheck, until - now);
			}
		});
		return nextCheck;
	}

	var untilTimer = 0;

	function watchExpired() {
		window.clearTimeout(untilTimer);
		var wait = hideExpired(document);
		if (wait !== Infinity) {
			untilTimer = window.setTimeout(watchExpired, Math.min(wait + 50, 3600000));
		}
	}

	function initAll(scope) {
		(scope || document).querySelectorAll('[data-scl-flipclock]').forEach(init);
		watchExpired();
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
