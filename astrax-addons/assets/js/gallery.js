/**
 * Astrax Addons — Gallery Component Script
 * Handles image loading, lightbox triggers, and optional Masonry layouts.
 */
(function($) {
	'use strict';

	function initGallery($scope) {
		const $gallery = $scope.find('.astrax-gallery');
		if (!$gallery.length) return;

		$gallery.each(function() {
			const $this = $(this);
			// Lightbox click delegation
			$this.on('click', '.astrax-gallery__item a', function(e) {
				const href = $(this).attr('href');
				if (href && href.match(/\.(jpeg|jpg|gif|png|webp|avif)$/i)) {
					// Elementor lightbox integration if available
					if (typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.lightbox) {
						e.preventDefault();
						elementorFrontend.utils.lightbox.openModal({
							url: href
						});
					}
				}
			});
		});
	}

	$(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction('frontend/element_ready/astrax-gallery.default', initGallery);
	});
})(jQuery);
