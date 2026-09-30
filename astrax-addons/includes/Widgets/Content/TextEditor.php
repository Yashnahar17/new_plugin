<?php
namespace AstraxAddons\Widgets\Content;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Text Editor Widget — Rich WYSIWYG text block.
 */
class TextEditor extends BaseWidget {

	public function get_name() {
		return 'astrax-text-editor';
	}

	public function get_title() {
		return esc_html__( 'Text Editor', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-text';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_editor',
			[
				'label' => esc_html__( 'Text Editor', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'editor',
			[
				'label'   => '',
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'astrax-addons' ),
			]
		);

		$this->add_control(
			'text_align',
			[
				'label'   => esc_html__( 'Alignment', 'astrax-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [ 'title' => esc_html__( 'Left', 'astrax-addons' ), 'icon' => 'eicon-text-align-left' ],
					'center'  => [ 'title' => esc_html__( 'Center', 'astrax-addons' ), 'icon' => 'eicon-text-align-center' ],
					'right'   => [ 'title' => esc_html__( 'Right', 'astrax-addons' ), 'icon' => 'eicon-text-align-right' ],
					'justify' => [ 'title' => esc_html__( 'Justify', 'astrax-addons' ), 'icon' => 'eicon-text-align-justify' ],
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-text-editor' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Text', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .astrax-text-editor',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-text-editor' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'editor', 'class', 'astrax-text-editor' );
		?>
		<div <?php $this->print_render_attribute_string( 'editor' ); ?>>
			<?php echo RenderHelper::esc_rich_text( $settings['editor'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php
	}
}
