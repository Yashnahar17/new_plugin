<?php
namespace AstraxAddons\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AstraxAddons\Widgets\ImageAccordion;

/**
 * Test ImageAccordion
 */
class ImageAccordionTest extends TestCase {

	/**
	 * Basic instance test.
	 */
	public function test_instance() {
		$widget = new ImageAccordion();
		$this->assertInstanceOf( ImageAccordion::class, $widget );
		$this->assertEquals( 'astrax-image-accordion', $widget->get_name() );
	}

}
