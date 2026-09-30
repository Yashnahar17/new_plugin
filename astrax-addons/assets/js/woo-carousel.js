/**
 * Astrax Addons — WooCommerce Product Carousel Script
 * Slick integration or lightweight touch swipe carousel runner with Elementor hook integration.
 */
(function($) {
	'use strict';

	function initWooCarousel($scope) {
		const $carousel = $scope.find('.astrax-woo-carousel');
		if (!$carousel.length) return;

		$carousel.each(function() {
			const $this = $(this);
			const $productsList = $this.find('ul.products');
			if (!$productsList.length) return;

			// If Slick is available, initialize smoothly
			if (typeof $.fn.slick === 'function') {
				const slidesToShow = parseInt($this.data('slides-to-show'), 10) || 3;
				const autoplay = $this.data('autoplay') === 'yes' || $this.data('autoplay') === true;

				if ($productsList.hasClass('slick-initialized')) {
					$productsList.slick('unslick');
				}

				$productsList.slick({
					slidesToShow: slidesToShow,
					slidesToScroll: 1,
					autoplay: autoplay,
					autoplaySpeed: 4000,
					dots: true,
					arrows: true,
					responsive: [
						{
							breakpoint: 1024,
							settings: {
								slidesToShow: Math.min(slidesToShow, 2),
								slidesToScroll: 1
							}
						},
						{
							breakpoint: 640,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1
							}
						}
					]
				});
			}
		});
	}

	$(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction('frontend/element_ready/astrax-woo-product-carousel.default', initWooCarousel);
	});
})(jQuery);
