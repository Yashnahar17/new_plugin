<?php
namespace AstraxAddons\Widgets\Blog;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Comment Form Widget.
 *
 * @since 1.0.0
 */
class CommentForm extends BaseWidget {

	public function get_name() {
		return 'astrax-comment-form';
	}

	public function get_title() {
		return esc_html__( 'Comment Form', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-comments';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Comment Form', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Comment Form', 'astrax-addons' ),
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
				'selector' => '{{WRAPPER}} .astrax-comment-form__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-comment-form__title' => 'color: {{VALUE}};',
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
		$this->add_render_attribute( 'wrapper', 'class', 'astrax-comment-form' );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<h3 class="astrax-comment-form__title"><?php echo esc_html( $settings['title'] ); ?></h3>
		</div>
		<?php
	}
}