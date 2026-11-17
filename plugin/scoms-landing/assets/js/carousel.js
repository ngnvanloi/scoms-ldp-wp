(function () {
	'use strict';

	var LAYOUT = [
		{ x: 0, s: 1, op: 1 },
		{ x: 1.02, s: 0.86, op: 0.8 },
		{ x: 1.88, s: 0.72, op: 0.45 },
		{ x: 2.5, s: 0.6, op: 0 }
	];
	var SWIPE = 40;

	function init(root) {
		if (root.dataset.sclCarouselReady) {
			return;
		}
		var track = root.querySelector('[data-scl-track]');
		var cards = track ? Array.prototype.slice.call(track.querySelectorAll('[data-scl-slide]')) : [];
		if (cards.length < 2) {
			return;
		}
		root.dataset.sclCarouselReady = '1';

		var count = cards.length;
		var half = Math.floor(count / 2);
		var current = 0;
		var offsets = cards.map(function () {
			return null;
		});
		var prev = root.querySelector('[data-scl-prev]');
		var next = root.querySelector('[data-scl-next]');
		var counter = root.querySelector('[data-scl-count]');
		var live = root.querySelector('[data-scl-live-region]');
		var pointer = null;
		var suppressClick = false;
		var pointerFocus = false;

		function pad(n) {
			return n < 10 ? '0' + n : String(n);
		}

		function offsetOf(i) {
			return (i - current + count + half) % count - half;
		}

		function render(announce) {
			var jumped = [];
			cards.forEach(function (card, i) {
				var o = offsetOf(i);
				var a = Math.min(Math.abs(o), LAYOUT.length - 1);
				var step = LAYOUT[a];
				if (offsets[i] !== null && Math.abs(o - offsets[i]) > half) {
					card.classList.add('is-jump');
					jumped.push(card);
				}
				card.style.setProperty('--x', String(o < 0 ? -step.x : step.x));
				card.style.setProperty('--s', String(step.s));
				card.style.setProperty('--op', String(step.op));
				card.style.setProperty('--z', String(10 - a));
				card.setAttribute('data-pos', String(a));
				card.classList.toggle('is-current', o === 0);
				offsets[i] = o;
			});
			if (jumped.length) {
				void track.offsetWidth;
				jumped.forEach(function (card) {
					card.classList.remove('is-jump');
				});
			}
			if (counter) {
				counter.innerHTML = '<strong>' + pad(current + 1) + '</strong> / ' + pad(count);
			}
			if (live && announce) {
				var name = cards[current].getAttribute('data-name') || '';
				live.textContent = name + ', ' + (current + 1) + ' / ' + count;
			}
		}

		function go(index, announce) {
			current = (index + count) % count;
			render(announce);
		}

		root.classList.add('is-carousel');
		render(false);

		if (prev) {
			prev.addEventListener('click', function () {
				go(current - 1, true);
			});
		}
		if (next) {
			next.addEventListener('click', function () {
				go(current + 1, true);
			});
		}

		track.addEventListener('click', function (event) {
			if (suppressClick) {
				suppressClick = false;
				event.preventDefault();
				event.stopPropagation();
				return;
			}
			var card = event.target.closest('[data-scl-slide]');
			if (card && !card.classList.contains('is-current')) {
				event.preventDefault();
				event.stopPropagation();
				go(cards.indexOf(card), true);
			}
		}, true);

		track.addEventListener('pointerdown', function (event) {
			pointerFocus = true;
			if (event.pointerType === 'mouse' && event.button !== 0) {
				return;
			}
			pointer = { id: event.pointerId, x: event.clientX, y: event.clientY };
		});

		track.addEventListener('pointerup', function (event) {
			window.setTimeout(function () {
				pointerFocus = false;
			}, 0);
			if (!pointer || pointer.id !== event.pointerId) {
				return;
			}
			var dx = event.clientX - pointer.x;
			var dy = event.clientY - pointer.y;
			pointer = null;
			if (Math.abs(dx) > SWIPE && Math.abs(dx) > Math.abs(dy)) {
				suppressClick = true;
				window.setTimeout(function () {
					suppressClick = false;
				}, 400);
				go(current + (dx < 0 ? 1 : -1), true);
			}
		});

		track.addEventListener('pointercancel', function () {
			pointer = null;
			pointerFocus = false;
		});

		track.addEventListener('focusin', function (event) {
			if (pointerFocus) {
				return;
			}
			var card = event.target.closest('[data-scl-slide]');
			if (card && !card.classList.contains('is-current')) {
				go(cards.indexOf(card), true);
			}
		});

		root.addEventListener('keydown', function (event) {
			if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') {
				return;
			}
			event.preventDefault();
			go(current + (event.key === 'ArrowRight' ? 1 : -1), true);
			if (track.contains(document.activeElement)) {
				var target = cards[current].querySelector('button, a');
				if (target) {
					target.focus({ preventScroll: true });
				}
			}
		});
	}

	function initAll(scope) {
		(scope || document).querySelectorAll('[data-scl-carousel]').forEach(init);
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
