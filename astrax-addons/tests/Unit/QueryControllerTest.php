<?php
namespace AstraxAddons\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AstraxAddons\Utilities\QueryController;

/**
 * Test QueryController
 */
class QueryControllerTest extends TestCase {

	/**
	 * Test default query args.
	 */
	public function test_default_query_args() {
		$settings = [];
		$args = QueryController::build_query_args( $settings );

		$this->assertEquals( 'post', $args['post_type'] );
		$this->assertEquals( 'publish', $args['post_status'] );
		$this->assertEquals( 6, $args['posts_per_page'] );
		$this->assertEquals( 'date', $args['orderby'] );
		$this->assertEquals( 'DESC', $args['order'] );
	}

	/**
	 * Test custom settings.
	 */
	public function test_custom_query_args() {
		$settings = [
			'post_type'      => 'product',
			'posts_per_page' => '12',
			'orderby'        => 'title',
			'order'          => 'ASC',
			'categories'     => [ 1, 2, 3 ],
		];
		$args = QueryController::build_query_args( $settings );

		$this->assertEquals( 'product', $args['post_type'] );
		$this->assertEquals( 12, $args['posts_per_page'] );
		$this->assertEquals( 'title', $args['orderby'] );
		$this->assertEquals( 'ASC', $args['order'] );
		$this->assertEquals( [ 1, 2, 3 ], $args['category__in'] );
	}
}
