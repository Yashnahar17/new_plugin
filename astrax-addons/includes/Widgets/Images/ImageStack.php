<?php
namespace AstraxAddons\Widgets\Images;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class ImageStack extends PlannedGalleryWidget {
	const KEY = 'image-stack';
	const LABEL = 'Image Stack';
	const TYPE = 'stack';

	public function get_icon() {
		return 'eicon-image-rollover';
	}
}
