<?php
namespace AstraxAddons\Widgets\Dynamic;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dynamic Date Widget.
 *
 * @since 1.0.0
 */
class DynamicDate extends BaseWidget {

	public function get_name() {
		return 'astrax-dynamic-date';
	}

	public function get_title() {
		return esc_html__( 'Dynamic Date', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-date';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Dynamic', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Dynamic Date', 'astrax-addons' ),
				'dynamic' => [ 'active' => true ],
			]
		);

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
				'selector' => '{{WRAPPER}} .astrax-dynamic-date__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-dynamic-date__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( empty( $settings['title'] ) ) {
			return;
		}
		$this->add_render_attribute( 'wrapper', 'class', 'astrax-dynamic-date' );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<h3 class="astrax-dynamic-date__title"><?php echo esc_html( $settings['title'] ); ?></h3>
		</div>
		<?php
	}
}