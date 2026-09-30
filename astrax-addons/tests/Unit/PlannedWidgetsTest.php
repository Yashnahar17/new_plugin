<?php
namespace AstraxAddons\Tests\Unit;

use PHPUnit\Framework\TestCase;

class PlannedWidgetsTest extends TestCase {
	public function test_planned_widget_names_are_unique_and_assets_are_declared() {
		$widget_classes = [
			\AstraxAddons\Widgets\Content\Heading::class,
			\AstraxAddons\Widgets\Content\RichText::class,
			\AstraxAddons\Widgets\Content\Icon::class,
			\AstraxAddons\Widgets\Content\Image::class,
			\AstraxAddons\Widgets\Content\ImageText::class,
			\AstraxAddons\Widgets\Content\Button::class,
			\AstraxAddons\Widgets\Content\Label::class,
			\AstraxAddons\Widgets\Content\Divider::class,
			\AstraxAddons\Widgets\Content\Spacer::class,
			\AstraxAddons\Widgets\Content\DropCap::class,
			\AstraxAddons\Widgets\Content\HighlightText::class,
			\AstraxAddons\Widgets\Content\ReadMore::class,
			\AstraxAddons\Widgets\Images\MasonryGallery::class,
			\AstraxAddons\Widgets\Images\JustifiedGallery::class,
			\AstraxAddons\Widgets\Images\ImageCarousel::class,
			\AstraxAddons\Widgets\Images\ImageSlider::class,
			\AstraxAddons\Widgets\Images\ImageStack::class,
			\AstraxAddons\Widgets\Images\ImageReveal::class,
			\AstraxAddons\Widgets\Images\ImageMask::class,
			\AstraxAddons\Widgets\Images\ImageHoverEffects::class,
			\AstraxAddons\Widgets\Images\InteractiveImage::class,
			\AstraxAddons\Widgets\Images\FloatingImage::class,
			\AstraxAddons\Widgets\Images\ScrollingImage::class,
			\AstraxAddons\Widgets\Images\ImageMagnifier::class,
			\AstraxAddons\Widgets\Images\LightboxGallery::class,
		];
		$names = [];

		foreach ( $widget_classes as $widget_class ) {
			$widget = new $widget_class();
			$names[] = $widget->get_name();
			$this->assertSame( [ 'astrax-v3-widgets' ], $widget->get_style_depends() );
		}

		$this->assertCount( 25, $names );
		$this->assertCount( 25, array_unique( $names ) );
	}

	public function test_only_interactive_image_widgets_require_the_shared_script() {
		$script_widgets = [
			new \AstraxAddons\Widgets\Images\ImageCarousel(),
			new \AstraxAddons\Widgets\Images\ImageSlider(),
			new \AstraxAddons\Widgets\Images\ImageReveal(),
			new \AstraxAddons\Widgets\Images\InteractiveImage(),
		];

		foreach ( $script_widgets as $widget ) {
			$this->assertSame( [ 'astrax-v3-widgets' ], $widget->get_script_depends() );
		}

		$this->assertSame( [], ( new \AstraxAddons\Widgets\Images\FloatingImage() )->get_script_depends() );
	}
}
