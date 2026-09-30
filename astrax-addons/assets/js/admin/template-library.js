/**
 * Astrax Addons Template Library
 */
(function($) {
	'use strict';

	if (typeof elementor === 'undefined') {
		return;
	}

	elementor.on('preview:loaded', function() {
		// Mock registering a new button in the elementor add section area
		var $addSectionBtn = $('#elementor-add-new-section');
		if ($addSectionBtn.length) {
			var $btn = $('<div class="elementor-add-section-area-button elementor-add-astrax-button" title="Add Astrax Template"><i class="eicon-star"></i></div>');
			$btn.on('click', function() {
				// Handle modal opening here
				console.log('Open Astrax Template Library');
			});
			$addSectionBtn.find('.elementor-add-section-drag-title').before($btn);
		}
	});

})(jQuery);
