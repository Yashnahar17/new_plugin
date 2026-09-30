<?php
namespace AstraxAddons\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AstraxAddons\Utilities\RenderHelper;

/**
 * Test RenderHelper
 */
class RenderHelperTest extends TestCase {

	/**
	 * Test esc_rich_text escaping behavior.
	 */
	public function test_esc_rich_text() {
		$unsafe   = '<b>Safe</b> <script>alert(1);</script>';
		$expected = '<b>Safe</b> alert(1);';
		$this->assertEquals( $expected, RenderHelper::esc_rich_text( $unsafe ) );
	}

	/**
	 * Test generate_inline_styles behavior.
	 */
	public function test_generate_inline_styles() {
		$styles = [
			'color'  => '#ff0000',
			'margin' => '10px "hack"',
		];
		$expected = 'color:#ff0000;margin:10px &quot;hack&quot;;';
		$this->assertEquals( $expected, RenderHelper::generate_inline_styles( $styles ) );
	}
}
