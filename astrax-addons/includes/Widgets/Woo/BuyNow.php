<?php
namespace AstraxAddons\Widgets\Woo;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Buy Now Widget.
 *
 * @since 1.0.0
 */
class BuyNow extends BaseWidget {

	public function get_name() {
		return 'astrax-woo-buy-now';
	}

	public function get_title() {
		return esc_html__( 'Buy Now', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-cart';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Buy Now', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Button Label', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Buy Now', 'astrax-addons' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .astrax-woo-buy-now__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-woo-buy-now__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			$this->render_empty_state( esc_html__( 'WooCommerce is not active.', 'astrax-addons' ) );
			return;
		}

		$settings = $this->get_settings_for_display();
		$variant  = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
		?>
		<div class="astrax-woo-widget astrax-woo-buy-now astrax-variant-<?php echo esc_attr( $variant ); ?>">
			<button type="button" class="button alt astrax-woo-buy-now-btn">
				<span class="astrax-woo-buy-now__title"><?php echo esc_html( $settings['title'] ); ?></span>
			</button>
		</div>
		<?php
	}
}