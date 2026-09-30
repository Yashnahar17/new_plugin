<?php
namespace AstraxAddons\Widgets\ACF;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ACF Text Widget.
 *
 * @since 1.0.0
 */
class AcfText extends BaseWidget {

	public function get_name() {
		return 'astrax-acf-text';
	}

	public function get_title() {
		return esc_html__( 'ACF Text', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-text';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'ACF', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Fallback Title', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'ACF Text Value', 'astrax-addons' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'field_name',
			[
				'label'       => esc_html__( 'ACF Field Name', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'my_custom_text_field',
				'description' => esc_html__( 'Enter the ACF field slug.', 'astrax-addons' ),
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
				'selector' => '{{WRAPPER}} .astrax-acf-text__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-acf-text__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$variant  = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
		$value    = $settings['title'];

		if ( function_exists( 'get_field' ) && ! empty( $settings['field_name'] ) ) {
			$acf_val = get_field( sanitize_key( $settings['field_name'] ) );
			if ( ! empty( $acf_val ) && is_scalar( $acf_val ) ) {
				$value = (string) $acf_val;
			}
		}

		?>
		<div class="astrax-acf-widget astrax-acf-text astrax-variant-<?php echo esc_attr( $variant ); ?>">
			<span class="astrax-acf-text__title"><?php echo esc_html( $value ); ?></span>
		</div>
		<?php
	}
}