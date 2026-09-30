<?php
namespace AstraxAddons\Utilities;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Query Controller.
 *
 * Provides a standardized way to build WP_Query arguments based on
 * widget settings for dynamic content widgets (e.g., Post Grid).
 *
 * @since 1.0.0
 */
class QueryController {

	/**
	 * Build WP_Query arguments from widget settings.
	 *
	 * @param array $settings Widget settings.
	 * @return array WP_Query args.
	 */
	public static function build_query_args( $settings ) {
		$posts_per_page = isset( $settings['posts_per_page'] ) ? absint( $settings['posts_per_page'] ) : 6;
		if ( $posts_per_page <= 0 ) {
			$posts_per_page = 6;
		}
		// Bound maximum query limit to prevent memory exhaustion / DoS
		if ( $posts_per_page > 100 ) {
			$posts_per_page = 100;
		}

		$post_type = ! empty( $settings['post_type'] ) ? sanitize_key( $settings['post_type'] ) : 'post';
		$order     = ( isset( $settings['order'] ) && 'ASC' === strtoupper( $settings['order'] ) ) ? 'ASC' : 'DESC';
		
		$allowed_orderby = [ 'date', 'title', 'ID', 'rand', 'comment_count', 'modified', 'menu_order' ];
		$orderby         = ( isset( $settings['orderby'] ) && in_array( $settings['orderby'], $allowed_orderby, true ) ) ? $settings['orderby'] : 'date';

		$args = [
			'post_type'           => $post_type,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $posts_per_page,
			'orderby'             => $orderby,
			'order'               => $order,
		];

		// Pagination support
		if ( ! empty( $settings['paged'] ) ) {
			$args['paged'] = max( 1, absint( $settings['paged'] ) );
		}

		// Offset support
		if ( ! empty( $settings['offset'] ) ) {
			$args['offset'] = absint( $settings['offset'] );
		}

		// Search term support
		if ( ! empty( $settings['search'] ) ) {
			$args['s'] = sanitize_text_field( $settings['search'] );
		}

		if ( ! empty( $settings['exclude_current'] ) && 'yes' === $settings['exclude_current'] ) {
			if ( function_exists( 'is_singular' ) && is_singular() ) {
				$current_id = get_the_ID();
				if ( $current_id ) {
					$args['post__not_in'] = [ $current_id ];
				}
			}
		}

		if ( ! empty( $settings['categories'] ) && is_array( $settings['categories'] ) ) {
			$args['category__in'] = array_map( 'absint', $settings['categories'] );
		}

		// Dynamic taxonomy support
		if ( ! empty( $settings['taxonomy'] ) && ! empty( $settings['terms'] ) ) {
			$args['tax_query'] = [
				[
					'taxonomy' => sanitize_key( $settings['taxonomy'] ),
					'field'    => 'term_id',
					'terms'    => is_array( $settings['terms'] ) ? array_map( 'absint', $settings['terms'] ) : [ absint( $settings['terms'] ) ],
				],
			];
		}

		return apply_filters( 'astrax_addons/query_args', $args, $settings );
	}

	/**
	 * Build and execute WP_Query safely.
	 *
	 * @param array $settings Widget settings.
	 * @return \WP_Query
	 */
	public static function build_query( $settings ) {
		$args = self::build_query_args( $settings );
		return new \WP_Query( $args );
	}
}
