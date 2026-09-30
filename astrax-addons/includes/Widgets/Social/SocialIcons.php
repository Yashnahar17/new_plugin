<?php
namespace AstraxAddons\Widgets\Social;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Social Icons Widget.
 *
 * @since 1.0.0
 */
class SocialIcons extends BaseWidget {

	public function get_name() {
		return 'astrax-social-icons';
	}

	public function get_title() {
		return esc_html__( 'Social Icons', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-social-icons';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Icons', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Social Icons', 'astrax-addons' ),
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
				'selector' => '{{WRAPPER}} .astrax-social-icons__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-social-icons__title' => 'color: {{VALUE}};',
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
		$this->add_render_attribute( 'wrapper', 'class', 'astrax-social-icons' );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<h3 class="astrax-social-icons__title"><?php echo esc_html( $settings['title'] ); ?></h3>
		</div>
		<?php
	}
}