<?php
namespace AstraxAddons\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AstraxAddons\Widgets\IconBox;

/**
 * Test IconBox
 */
class IconBoxTest extends TestCase {

	/**
	 * Basic instance test.
	 */
	public function test_instance() {
		$widget = new IconBox();
		$this->assertInstanceOf( IconBox::class, $widget );
		$this->assertEquals( 'astrax-icon-box', $widget->get_name() );
	}

}
