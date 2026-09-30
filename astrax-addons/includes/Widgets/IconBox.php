<?php
namespace AstraxAddons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icon Box Widget.
 */
class IconBox extends BaseWidget {

	/**
	 * Get widget name.
	 */
	public function get_name() {
		return 'astrax-icon-box';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return esc_html__( 'Icon Box', 'astrax-addons' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'eicon-icon-box';
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_icon_box',
			[
				'label' => esc_html__( 'Icon Box', 'astrax-addons' ),
				'tab   ' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_icon_control( 'icon', 'fas fa-star' );

		$this->add_control(
			'title_text',
			[
				'label'       => esc_html__( 'Title & Description', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => esc_html__( 'This is the heading', 'astrax-addons' ),
				'placeholder' => esc_html__( 'Enter your title', 'astrax-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'description_text',
			[
				'label'       => esc_html__( 'Description', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'astrax-addons' ),
				'placeholder' => esc_html__( 'Enter your description', 'astrax-addons' ),
				'rows'        => 10,
			]
		);

		$this->add_html_tag_control( 'title_size', 'h3', esc_html__( 'Title HTML Tag', 'astrax-addons' ) );

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-icon-box-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .astrax-icon-box-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 12,
						'max' => 96,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .astrax-icon-box-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .astrax-icon-box-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_typography_control( 'title_typography', '{{WRAPPER}} .astrax-icon-box-title' );

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-icon-box-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_typography_control( 'desc_typography', '{{WRAPPER}} .astrax-icon-box-description' );

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-icon-box-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_alignment_control( 'box_align', '{{WRAPPER}} .astrax-icon-box-wrapper' );

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$variant = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
		$this->add_render_attribute( 'wrapper', 'class', [
			'astrax-widget',
			'astrax-icon-box-wrapper',
			'astrax-variant-' . $variant,
		] );
		$this->add_render_attribute( 'icon_wrapper', 'class', 'astrax-icon-box-icon' );
		$this->add_render_attribute( 'content_wrapper', 'class', 'astrax-icon-box-content' );
		$this->add_render_attribute( 'title', 'class', 'astrax-icon-box-title' );
		$this->add_render_attribute( 'description', 'class', 'astrax-icon-box-description' );

		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( ! empty( $settings['icon']['value'] ) ) : ?>
				<div <?php $this->print_render_attribute_string( 'icon_wrapper' ); ?>>
					<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</div>
			<?php endif; ?>

			<div <?php $this->print_render_attribute_string( 'content_wrapper' ); ?>>
				<?php if ( ! empty( $settings['title_text'] ) ) : ?>
					<?php
					$this->render_html_tag(
						$settings['title_size'],
						esc_html( $settings['title_text'] ),
						[ 'class' => 'astrax-icon-box-title' ]
					);
					?>
				<?php endif; ?>

				<?php if ( ! empty( $settings['description_text'] ) ) : ?>
					<p <?php $this->print_render_attribute_string( 'description' ); ?>>
						<?php echo RenderHelper::esc_rich_text( $settings['description_text'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
