<?php
namespace AstraxAddons\Widgets\FAQ;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Glossary Widget.
 *
 * @since 1.0.0
 */
class Glossary extends BaseWidget {

	public function get_name() {
		return 'astrax-glossary';
	}

	public function get_title() {
		return esc_html__( 'Glossary', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Glossary', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Glossary', 'astrax-addons' ),
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
				'selector' => '{{WRAPPER}} .astrax-glossary__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-glossary__title' => 'color: {{VALUE}};',
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
		$this->add_render_attribute( 'wrapper', 'class', 'astrax-glossary' );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<h3 class="astrax-glossary__title"><?php echo esc_html( $settings['title'] ); ?></h3>
		</div>
		<?php
	}
}