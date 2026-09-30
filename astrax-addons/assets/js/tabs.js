/**
 * Astrax Addons — Tabs Component Script
 * Accessible keyboard navigation (ArrowLeft, ArrowRight, Home, End), ARIA sync, and Elementor lifecycle hooks.
 */
(function($) {
	'use strict';

	function initAstraxTabs($scope) {
		const $tabsContainer = $scope.find('.astrax-tabs');
		if (!$tabsContainer.length) return;

		$tabsContainer.each(function() {
			const $container = $(this);
			const $titles = $container.find('.astrax-tab-title');
			const $panels = $container.find('.astrax-tab-content');

			$titles.on('click', function(e) {
				e.preventDefault();
				const $clicked = $(this);
				const targetTab = $clicked.data('tab');

				$titles.removeClass('active').attr({
					'aria-selected': 'false',
					'tabindex': '-1'
				});
				$clicked.addClass('active').attr({
					'aria-selected': 'true',
					'tabindex': '0'
				});

				$panels.removeClass('active').attr('hidden', true);
				$panels.filter('[data-tab="' + targetTab + '"]').addClass('active').removeAttr('hidden');
			});

			// Accessible Keyboard Navigation
			$titles.on('keydown', function(e) {
				const index = $titles.index(this);
				let targetIndex = null;

				if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
					targetIndex = (index + 1) % $titles.length;
				} else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
					targetIndex = (index - 1 + $titles.length) % $titles.length;
				} else if (e.key === 'Home') {
					targetIndex = 0;
				} else if (e.key === 'End') {
					targetIndex = $titles.length - 1;
				}

				if (targetIndex !== null) {
					e.preventDefault();
					$titles.eq(targetIndex).focus().trigger('click');
				}
			});
		});
	}

	$(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction('frontend/element_ready/astrax-tabs.default', initAstraxTabs);
	});
})(jQuery);
