<?php
namespace AstraxAddons\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AstraxAddons\Compatibility\CompatibilityManager;

/**
 * Test CompatibilityManager
 */
class CompatibilityManagerTest extends TestCase {

	/**
	 * Basic instance test.
	 */
	public function test_instance() {
		$manager = new CompatibilityManager();
		$this->assertInstanceOf( CompatibilityManager::class, $manager );
	}

}
