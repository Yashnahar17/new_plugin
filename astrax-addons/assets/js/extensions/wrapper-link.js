/**
 * Astrax Wrapper Link Extension
 *
 * Makes elements with [data-astrax-wrapper-link] clickable.
 * Supports external links and keyboard accessibility (Enter/Space).
 *
 * Security: Only navigates to URLs set server-side via esc_url().
 * Accessibility: role="link" and tabindex="0" are set server-side.
 *
 * @since 1.0.0
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		const wrapperLinks = document.querySelectorAll('[data-astrax-wrapper-link]');

		wrapperLinks.forEach(function (el) {
			const url = el.getAttribute('data-astrax-wrapper-link');
			if (!url) {
				return;
			}

			const isExternal = el.getAttribute('data-astrax-wrapper-link-external') === 'true';

			// Click handler.
			el.addEventListener('click', function (e) {
				// Don't hijack clicks on actual links or buttons inside.
				if (e.target.closest('a, button, input, textarea, select')) {
					return;
				}

				if (isExternal) {
					window.open(url, '_blank', 'noopener,noreferrer');
				} else {
					window.location.href = url;
				}
			});

			// Keyboard handler for Enter and Space.
			el.addEventListener('keydown', function (e) {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					if (isExternal) {
						window.open(url, '_blank', 'noopener,noreferrer');
					} else {
						window.location.href = url;
					}
				}
			});
		});
	});
})();
