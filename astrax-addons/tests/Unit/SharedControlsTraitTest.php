<?php
namespace AstraxAddons\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AstraxAddons\Utilities\SharedControlsTrait;

class DummyWidgetUsingSharedControls {
	use SharedControlsTrait;

	public $controls = [];
	public $group_controls = [];

	public function add_control( $id, $args ) {
		$this->controls[ $id ] = $args;
	}

	public function add_group_control( $type, $args ) {
		$this->group_controls[ $type ] = $args;
	}
}

/**
 * Test SharedControlsTrait
 */
class SharedControlsTraitTest extends TestCase {

	/**
	 * Test get_allowed_html_tags
	 */
	public function test_get_allowed_html_tags() {
		$tags = DummyWidgetUsingSharedControls::get_allowed_html_tags();
		$this->assertIsArray( $tags );
		$this->assertArrayHasKey( 'h1', $tags );
		$this->assertArrayHasKey( 'p', $tags );
		$this->assertArrayHasKey( 'div', $tags );
	}

	/**
	 * Test add_html_tag_control
	 */
	public function test_add_html_tag_control() {
		$dummy = new DummyWidgetUsingSharedControls();
		$dummy->add_html_tag_control( 'custom_tag', 'h3' );

		$this->assertArrayHasKey( 'custom_tag', $dummy->controls );
		$this->assertEquals( 'h3', $dummy->controls['custom_tag']['default'] );
	}

	/**
	 * Test add_link_control
	 */
	public function test_add_link_control() {
		$dummy = new DummyWidgetUsingSharedControls();
		$dummy->add_link_control( 'item_link' );

		$this->assertArrayHasKey( 'item_link', $dummy->controls );
		$this->assertTrue( $dummy->controls['item_link']['dynamic']['active'] );
	}

	/**
	 * Test add_icon_control
	 */
	public function test_add_icon_control() {
		$dummy = new DummyWidgetUsingSharedControls();
		$dummy->add_icon_control( 'badge_icon', 'fas fa-check' );

		$this->assertArrayHasKey( 'badge_icon', $dummy->controls );
		$this->assertEquals( 'fas fa-check', $dummy->controls['badge_icon']['default']['value'] );
	}
}
