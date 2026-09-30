<?php
namespace AstraxAddons\Widgets;

use Elementor\Controls_Manager;
use AstraxAddons\Utilities\QueryController;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce Product Grid Widget.
 */
class WooProductGrid extends BaseWidget {

	/**
	 * Get widget name.
	 */
	public function get_name() {
		return 'astrax-woo-product-grid';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return esc_html__( 'Woo Product Grid', 'astrax-addons' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'eicon-woocommerce';
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'astrax-addons' ),
				'tab   '=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Products Per Page', 'astrax-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'       => esc_html__( 'Date', 'astrax-addons' ),
					'title'      => esc_html__( 'Title', 'astrax-addons' ),
					'price'      => esc_html__( 'Price', 'astrax-addons' ),
					'popularity' => esc_html__( 'Sales', 'astrax-addons' ),
					'rating'     => esc_html__( 'Rating', 'astrax-addons' ),
					'rand'       => esc_html__( 'Random', 'astrax-addons' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC'  => esc_html__( 'Ascending', 'astrax-addons' ),
					'DESC' => esc_html__( 'Descending', 'astrax-addons' ),
				],
			]
		);

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_grid_style',
			[
				'label' => esc_html__( 'Product Grid Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_typography_control( 'title_typography', '{{WRAPPER}} .woocommerce-loop-product__title' );

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-loop-product__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => esc_html__( 'Price Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .price, {{WRAPPER}} .price .amount' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Card Border Radius', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ul.products li.product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="astrax-empty-state"><p>' . esc_html__( 'WooCommerce is not active.', 'astrax-addons' ) . '</p></div>';
			return;
		}

		$settings = $this->get_settings_for_display();

		// Add post_type to settings before passing to query builder.
		$settings['post_type'] = 'product';

		$query_args = QueryController::build_query_args( $settings );

		// Adjust for WooCommerce specific ordering
		if ( 'price' === $settings['orderby'] ) {
			$query_args['orderby']  = 'meta_value_num';
			$query_args['meta_key'] = '_price';
		} elseif ( 'popularity' === $settings['orderby'] ) {
			$query_args['orderby']  = 'meta_value_num';
			$query_args['meta_key'] = 'total_sales';
		}

		$query = new \WP_Query( $query_args );

		if ( ! $query->have_posts() ) {
			$this->render_empty_state( esc_html__( 'No products found.', 'astrax-addons' ) );
			return;
		}

		$variant = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
		$wrapper_classes = [
			'astrax-woo-grid',
			'woocommerce',
			'astrax-variant-' . $variant,
		];

		$this->render_wrapper_start( $wrapper_classes );
		echo '<ul class="products columns-4">';
		while ( $query->have_posts() ) {
			$query->the_post();
			wc_get_template_part( 'content', 'product' );
		}
		echo '</ul>';
		$this->render_wrapper_end();

		wp_reset_postdata();
	}
}
