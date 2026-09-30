<?php
namespace AstraxAddons\Widgets\Images;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class ImageSlider extends PlannedGalleryWidget {
	const KEY = 'image-slider';
	const LABEL = 'Image Slider';
	const TYPE = 'slider';

	public function get_icon() {
		return 'eicon-slides';
	}
}
