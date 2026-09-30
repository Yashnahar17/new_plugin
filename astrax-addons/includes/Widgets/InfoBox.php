<?php
namespace AstraxAddons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Info Box Widget.
 */
class InfoBox extends BaseWidget {

	/**
	 * Get widget name.
	 */
	public function get_name() {
		return 'astrax-info-box';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return esc_html__( 'Info Box', 'astrax-addons' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'eicon-info-box';
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_info_box_content',
			[
				'label' => esc_html__( 'Info Box Content', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'astrax-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'thumbnail',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'title_text',
			[
				'label'       => esc_html__( 'Title', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => esc_html__( 'Info Box Title', 'astrax-addons' ),
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
				'default'     => esc_html__( 'This is the description for the info box.', 'astrax-addons' ),
				'placeholder' => esc_html__( 'Enter your description', 'astrax-addons' ),
				'rows'        => 5,
			]
		);

		$this->add_link_control( 'link' );

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_info_style',
			[
				'label' => esc_html__( 'Info Box Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Image Border Radius', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .astrax-info-box-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_typography_control( 'title_typography', '{{WRAPPER}} .astrax-info-box-title' );

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-info-box-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_typography_control( 'desc_typography', '{{WRAPPER}} .astrax-info-box-description' );

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-info-box-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_alignment_control( 'box_align', '{{WRAPPER}} .astrax-info-box-wrapper' );

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
			'astrax-info-box-wrapper',
			'astrax-variant-' . $variant,
		] );
		
		$wrapper_tag = 'div';
		if ( ! empty( $settings['link']['url'] ) ) {
			$wrapper_tag = 'a';
			$this->add_link_attributes( 'wrapper', $settings['link'] );
		}

		?>
		<<?php echo esc_html( $wrapper_tag ); ?> <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			
			<?php if ( ! empty( $settings['image']['url'] ) ) : ?>
				<div class="astrax-info-box-image">
					<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image' ); ?>
				</div>
			<?php endif; ?>

			<div class="astrax-info-box-content">
				<?php if ( ! empty( $settings['title_text'] ) ) : ?>
					<h3 class="astrax-info-box-title">
						<?php echo esc_html( $settings['title_text'] ); ?>
					</h3>
				<?php endif; ?>

				<?php if ( ! empty( $settings['description_text'] ) ) : ?>
					<div class="astrax-info-box-description">
						<?php echo RenderHelper::esc_rich_text( $settings['description_text'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php endif; ?>
			</div>

		</<?php echo esc_html( $wrapper_tag ); ?>>
		<?php
	}
}
