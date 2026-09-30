<?php
namespace AstraxAddons\Tests\Unit;

use AstraxAddons\Widgets\WidgetRegistry;
use PHPUnit\Framework\TestCase;

class WidgetRegistryTest extends TestCase {
	public function test_registry_contains_every_currently_registered_widget() {
		$widgets = WidgetRegistry::all();

		$this->assertCount( 405, $widgets );
		$this->assertSame( 'Advanced Heading', $widgets['advanced-heading']['name'] );
		$this->assertSame( 'AstraxAddons\\Widgets\\Images\\LightboxGallery', $widgets['lightbox-gallery']['class'] );
	}

	public function test_each_widget_has_a_loadable_metadata_shape() {
		foreach ( WidgetRegistry::all() as $widget ) {
			$this->assertNotSame( '', $widget['name'] );
			$this->assertStringStartsWith( 'AstraxAddons\\Widgets\\', $widget['class'] );
			$this->assertStringStartsWith( 'Widgets/', $widget['file'] );
		}
	}
}
