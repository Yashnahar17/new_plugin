<?php
namespace AstraxAddons\Widgets\Images;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class ImageCarousel extends PlannedGalleryWidget {
	const KEY = 'image-carousel';
	const LABEL = 'Image Carousel';
	const TYPE = 'carousel';

	public function get_icon() {
		return 'eicon-carousel';
	}
}
