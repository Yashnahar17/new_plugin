/**
 * Astrax Motion & Parallax Extension
 *
 * Applies scroll-driven motion effects using IntersectionObserver
 * and requestAnimationFrame. No jQuery dependency.
 *
 * Reduced motion: Respects `prefers-reduced-motion: reduce`.
 * All effects are disabled and elements are shown at their default
 * position/opacity when reduced motion is active.
 *
 * @since 1.0.0
 */
(function () {
	'use strict';

	// Bail if reduced motion is preferred.
	var motionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
	if (motionQuery.matches) {
		return;
	}

	// Speed multipliers.
	var speedMap = {
		slow: 0.3,
		normal: 0.6,
		fast: 1.0,
	};

	/**
	 * Calculate scroll progress for an element.
	 *
	 * @param {HTMLElement} el
	 * @returns {number} 0 (element entering viewport) to 1 (exiting).
	 */
	function getScrollProgress(el) {
		var rect = el.getBoundingClientRect();
		var viewHeight = window.innerHeight || document.documentElement.clientHeight;
		// Progress: 0 when bottom of element enters, 1 when top leaves.
		var progress = 1 - (rect.bottom / (viewHeight + rect.height));
		return Math.max(0, Math.min(1, progress));
	}

	/**
	 * Apply motion transforms to an element.
	 *
	 * @param {HTMLElement} el
	 * @param {Object} config
	 * @param {number} progress
	 */
	function applyMotion(el, config, progress) {
		var multiplier = speedMap[config.speed] || 0.6;
		var adjustedProgress = progress * multiplier;

		var translateY = config.translateY * adjustedProgress;
		var scale = 1 + (config.scale - 1) * adjustedProgress;
		var rotate = config.rotate * adjustedProgress;
		var opacity = 1 + (config.opacity - 1) * adjustedProgress;

		el.style.transform =
			'translateY(' + translateY + 'px) ' +
			'scale(' + scale + ') ' +
			'rotate(' + rotate + 'deg)';
		el.style.opacity = Math.max(0, Math.min(1, opacity));
	}

	document.addEventListener('DOMContentLoaded', function () {
		var motionElements = document.querySelectorAll('[data-astrax-motion]');
		if (!motionElements.length) {
			return;
		}

		// Parse configs once.
		var items = [];
		motionElements.forEach(function (el) {
			try {
				var config = JSON.parse(el.getAttribute('data-astrax-motion'));
				items.push({ el: el, config: config });
			} catch (e) {
				// Invalid JSON — skip this element silently.
			}
		});

		if (!items.length) {
			return;
		}

		var ticking = false;

		function onScroll() {
			if (!ticking) {
				requestAnimationFrame(function () {
					items.forEach(function (item) {
						var progress = getScrollProgress(item.el);
						applyMotion(item.el, item.config, progress);
					});
					ticking = false;
				});
				ticking = true;
			}
		}

		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll(); // Initial application.

		// Listen for reduced motion preference changes.
		motionQuery.addEventListener('change', function (e) {
			if (e.matches) {
				// Reset all effects.
				items.forEach(function (item) {
					item.el.style.transform = '';
					item.el.style.opacity = '';
				});
				window.removeEventListener('scroll', onScroll);
			}
		});
	});
})();
