<?php
namespace AstraxAddons\Widgets;

use Elementor\Controls_Manager;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Advanced Button Widget.
 */
class AdvancedButton extends BaseWidget {

	/**
	 * Get widget name.
	 */
	public function get_name() {
		return 'astrax-advanced-button';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return esc_html__( 'Advanced Button', 'astrax-addons' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'eicon-button';
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button Content', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Text', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Click Me', 'astrax-addons' ),
				'default'     => esc_html__( 'Click Me', 'astrax-addons' ),
			]
		);

		$this->add_link_control( 'button_link', esc_html__( 'Link', 'astrax-addons' ), 'https://your-link.com' );

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Button Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_typography_control( 'button_typography', '{{WRAPPER}} .astrax-button' );

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_alignment_control( 'align', '{{WRAPPER}} .astrax-advanced-button' );

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['button_text'] ) ) {
			return;
		}

		$variant = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
		$wrapper_classes = [
			'astrax-advanced-button',
			'astrax-variant-' . $variant,
		];

		$this->add_render_attribute( 'button', 'class', [ 'astrax-button', 'elementor-button', 'elementor-size-md' ] );
		$this->add_render_attribute( 'button', 'role', 'button' );

		// Handle links securely
		if ( ! empty( $settings['button_link']['url'] ) ) {
			$this->add_link_attributes( 'button', $settings['button_link'] );
		}

		// Security: Escape basic text
		$safe_text = esc_html( $settings['button_text'] );

		// Render the button inside standard wrapper
		$this->render_wrapper_start( $wrapper_classes );
		?>
		<a <?php $this->print_render_attribute_string( 'button' ); ?>>
			<span class="elementor-button-content-wrapper">
				<span class="elementor-button-text"><?php echo $safe_text; ?></span>
			</span>
		</a>
		<?php
		$this->render_wrapper_end();
	}
}
