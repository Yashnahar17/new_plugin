<?php
namespace AstraxAddons\Widgets;

use Elementor\Controls_Manager;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce Product Carousel Widget.
 */
class WooProductCarousel extends BaseWidget {

	public function get_name() {
		return 'astrax-woo-product-carousel';
	}

	public function get_title() {
		return esc_html__( 'Woo Product Carousel', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return [ 'astrax-addons' ];
	}
    
    public function get_script_depends() {
		return [ 'astrax-woo-carousel' ];
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
			'posts_per_page',
			[
				'label'   => esc_html__( 'Products Count', 'astrax-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
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

		$this->end_controls_section();
        
        $this->start_controls_section(
			'section_carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_responsive_control( 'slides_to_show', [
			'label'   => esc_html__( 'Slides to Show', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '3',
            'options' => [
                '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5',
            ]
		] );
        
        $this->add_control( 'autoplay', [
			'label'   => esc_html__( 'Autoplay', 'astrax-addons' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$this->add_design_variant_control( 'design_variant' );
        
        $this->end_controls_section();

		$this->start_controls_section(
			'section_carousel_style',
			[
				'label' => esc_html__( 'Carousel Style', 'astrax-addons' ),
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
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $settings['posts_per_page'],
			'orderby'             => $settings['orderby'],
			'order'               => $settings['order'],
		];

		// Handle specific Woo orderby clauses
		if ( 'price' === $args['orderby'] ) {
			$args['meta_key'] = '_price';
			$args['orderby']  = 'meta_value_num';
		} elseif ( 'popularity' === $args['orderby'] ) {
			$args['meta_key'] = 'total_sales';
			$args['orderby']  = 'meta_value_num';
		}

		$query = new \WP_Query( $args );

		if ( $query->have_posts() ) {
			$variant = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
            $this->add_render_attribute( 'wrapper', [
                'class'               => [ 'astrax-woo-carousel', 'woocommerce', 'astrax-variant-' . $variant ],
                'data-slides-to-show' => esc_attr( $settings['slides_to_show'] ),
                'data-autoplay'       => esc_attr( $settings['autoplay'] ),
            ] );
            
			echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
			echo '<ul class="products">';
			while ( $query->have_posts() ) {
				$query->the_post();
				wc_get_template_part( 'content', 'product' );
			}
			echo '</ul></div>';
			wp_reset_postdata();
		} else {
			echo '<div class="astrax-notice astrax-notice--info">' . esc_html__( 'No products found.', 'astrax-addons' ) . '</div>';
		}
	}
}
