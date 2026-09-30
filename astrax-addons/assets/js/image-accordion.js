(function($) {
	class AstraxImageAccordion {
		constructor($scope) {
			this.$accordion = $scope.find('.astrax-image-accordion');
			if (!this.$accordion.length) return;
			
			this.$items = this.$accordion.find('.astrax-ia-item');
			this.trigger = this.$accordion.data('trigger'); // 'hover' or 'click'
			
			this.bindEvents();
		}

		bindEvents() {
			const self = this;
			
			if (this.trigger === 'hover') {
				this.$items.on('mouseenter focus', function() {
					self.activateItem($(this));
				});
			} else {
				this.$items.on('click', function() {
					self.activateItem($(this));
				});
			}

			// Keyboard support (Arrows to navigate, Enter/Space to activate if on click)
			this.$accordion.on('keydown', '.astrax-ia-item', function(e) {
				let $current = $(this);
				let $next = null;

				if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
					e.preventDefault();
					$next = $current.next('.astrax-ia-item');
					if (!$next.length) $next = self.$items.first();
				} else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
					e.preventDefault();
					$next = $current.prev('.astrax-ia-item');
					if (!$next.length) $next = self.$items.last();
				} else if ((e.key === 'Enter' || e.key === ' ') && self.trigger === 'click') {
					e.preventDefault();
					self.activateItem($current);
				}

				if ($next) {
					$next.focus();
					if (self.trigger === 'hover') {
						self.activateItem($next);
					}
				}
			});
		}

		activateItem($item) {
			if ($item.hasClass('is-active')) return;
			
			this.$items.removeClass('is-active').attr('aria-selected', 'false').attr('tabindex', '-1');
			this.$items.find('a').attr('tabindex', '-1');
			
			$item.addClass('is-active').attr('aria-selected', 'true').attr('tabindex', '0');
			$item.find('a').attr('tabindex', '0');
		}
	}

	$(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction('frontend/element_ready/astrax-image-accordion.default', function($scope) {
			new AstraxImageAccordion($scope);
		});
	});
})(jQuery);
