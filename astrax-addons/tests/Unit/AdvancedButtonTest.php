<?php
namespace AstraxAddons\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AstraxAddons\Widgets\AdvancedButton;

/**
 * Test AdvancedButton
 */
class AdvancedButtonTest extends TestCase {

	/**
	 * Basic instance test.
	 */
	public function test_instance() {
		$widget = new AdvancedButton();
		$this->assertInstanceOf( AdvancedButton::class, $widget );
		$this->assertEquals( 'astrax-advanced-button', $widget->get_name() );
	}

}
