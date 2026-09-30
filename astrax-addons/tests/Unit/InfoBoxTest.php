<?php
namespace AstraxAddons\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AstraxAddons\Widgets\InfoBox;

/**
 * Test InfoBox
 */
class InfoBoxTest extends TestCase {

	/**
	 * Basic instance test.
	 */
	public function test_instance() {
		$widget = new InfoBox();
		$this->assertInstanceOf( InfoBox::class, $widget );
		$this->assertEquals( 'astrax-info-box', $widget->get_name() );
	}

}
