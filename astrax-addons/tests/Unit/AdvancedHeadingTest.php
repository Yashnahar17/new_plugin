<?php
namespace AstraxAddons\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AstraxAddons\Widgets\AdvancedHeading;

/**
 * Test AdvancedHeading
 */
class AdvancedHeadingTest extends TestCase {

	/**
	 * Basic instance test.
	 */
	public function test_instance() {
		$widget = new AdvancedHeading();
		$this->assertInstanceOf( AdvancedHeading::class, $widget );
		$this->assertEquals( 'astrax-advanced-heading', $widget->get_name() );
	}

}
