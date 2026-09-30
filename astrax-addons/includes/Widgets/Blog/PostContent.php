<?php
namespace AstraxAddons\Widgets\Blog;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post Content Widget.
 *
 * @since 1.0.0
 */
class PostContent extends BaseWidget {

	public function get_name() {
		return 'astrax-post-content';
	}

	public function get_title() {
		return esc_html__( 'Post Content', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-post-content';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Post Content', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Post Content', 'astrax-addons' ),
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
				'selector' => '{{WRAPPER}} .astrax-post-content__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-post-content__title' => 'color: {{VALUE}};',
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
		$this->add_render_attribute( 'wrapper', 'class', 'astrax-post-content' );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<h3 class="astrax-post-content__title"><?php echo esc_html( $settings['title'] ); ?></h3>
		</div>
		<?php
	}
}