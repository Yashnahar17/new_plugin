<?php
namespace AstraxAddons\Widgets;

use Elementor\Controls_Manager;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce Category Grid Widget.
 */
class WooCategoryGrid extends BaseWidget {

	public function get_name() {
		return 'astrax-woo-category-grid';
	}

	public function get_title() {
		return esc_html__( 'Woo Category Grid', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-product-categories';
	}

	public function get_categories() {
		return [ 'astrax-addons' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Categories Count', 'astrax-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
			]
		);

		$this->add_control(
			'hide_empty',
			[
				'label'   => esc_html__( 'Hide Empty', 'astrax-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
        
        $this->add_responsive_control( 'columns', [
			'label'   => esc_html__( 'Columns', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '3',
            'options' => [
                '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5',
            ]
		] );

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_category_grid_style',
			[
				'label' => esc_html__( 'Category Grid Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_typography_control( 'title_typography', '{{WRAPPER}} .woocommerce-loop-category__title' );

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-loop-category__title' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} ul.products li.product-category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		// Fallback if WooCommerce is not active.
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="astrax-notice astrax-notice--warning">' . esc_html__( 'WooCommerce is not active.', 'astrax-addons' ) . '</div>';
			return;
		}

		$settings = $this->get_settings_for_display();

		$args = [
            'taxonomy'   => 'product_cat',
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => ( 'yes' === $settings['hide_empty'] ),
			'number'     => $settings['limit'],
		];

		$product_categories = get_terms( $args );

		if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
			$variant = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
            $this->add_render_attribute( 'wrapper', [
                'class'         => [ 'astrax-woo-category-grid', 'woocommerce', 'astrax-variant-' . $variant ],
                'data-columns'  => esc_attr( $settings['columns'] ),
            ] );
            
			echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
			echo '<ul class="products">';
            
			foreach ( $product_categories as $category ) {
				wc_get_template(
                    'content-product_cat.php',
                    [
                        'category' => $category,
                    ]
                );
			}
            
			echo '</ul></div>';
		} else {
			echo '<div class="astrax-notice astrax-notice--info">' . esc_html__( 'No categories found.', 'astrax-addons' ) . '</div>';
		}
	}
}
