<?php
namespace AstraxAddons\Widgets\Business;

use Elementor\Controls_Manager;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pricing Table Widget.
 */
class PricingTable extends BaseWidget {

	public function get_name() {
		return 'astrax-pricing-table';
	}

	public function get_title() {
		return esc_html__( 'Pricing Table', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-price-table';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_pricing',
			[
				'label' => esc_html__( 'Pricing', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'title', [
			'label'   => esc_html__( 'Plan Name', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Pro Plan', 'astrax-addons' ),
		] );

		$this->add_control( 'price', [
			'label'   => esc_html__( 'Price', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( '$99', 'astrax-addons' ),
		] );

		$this->add_control( 'period', [
			'label'   => esc_html__( 'Period', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( '/ month', 'astrax-addons' ),
		] );

		$this->add_control( 'features', [
			'label'   => esc_html__( 'Features (one per line)', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXTAREA,
			'default' => "Feature 1\nFeature 2\nFeature 3",
		] );

		$this->add_control( 'button_text', [
			'label'   => esc_html__( 'Button Text', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Get Started', 'astrax-addons' ),
		] );

		$this->add_link_control( 'button_link', esc_html__( 'Button Link', 'astrax-addons' ) );

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pricing_style',
			[
				'label' => esc_html__( 'Pricing Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_typography_control( 'title_typography', '{{WRAPPER}} .astrax-pricing-title' );

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-pricing-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => esc_html__( 'Price Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-pricing-amount' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Button Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-pricing-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$features = explode( "\n", $settings['features'] );
		$variant  = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';

		$this->add_render_attribute( 'wrapper', 'class', [ 'astrax-pricing-table', 'astrax-variant-' . $variant ] );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div class="astrax-pricing-header">
				<h3 class="astrax-pricing-title"><?php echo esc_html( $settings['title'] ); ?></h3>
				<div class="astrax-pricing-price-wrap">
					<span class="astrax-pricing-amount"><?php echo esc_html( $settings['price'] ); ?></span>
					<span class="astrax-pricing-period"><?php echo esc_html( $settings['period'] ); ?></span>
				</div>
			</div>
			<div class="astrax-pricing-features">
				<ul>
					<?php foreach ( $features as $feature ) : ?>
						<?php if ( ! empty( trim( $feature ) ) ) : ?>
							<li><?php echo esc_html( trim( $feature ) ); ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php if ( ! empty( $settings['button_text'] ) ) : ?>
				<div class="astrax-pricing-footer">
					<?php
					$this->add_render_attribute( 'btn', 'class', 'astrax-pricing-button' );
					if ( ! empty( $settings['button_link']['url'] ) ) {
						$this->add_link_attributes( 'btn', $settings['button_link'] );
					}
					?>
					<a <?php $this->print_render_attribute_string( 'btn' ); ?>>
						<?php echo esc_html( $settings['button_text'] ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
