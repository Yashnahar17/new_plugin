<?php
namespace AstraxAddons\Widgets\Content;

use Elementor\Controls_Manager;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Badge Widget — Small label/badge for highlighting content.
 */
class Badge extends BaseWidget {

	public function get_name() {
		return 'astrax-badge';
	}

	public function get_title() {
		return esc_html__( 'Badge', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-alert';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_badge',
			[
				'label' => esc_html__( 'Badge', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'badge_text', [
			'label'   => esc_html__( 'Text', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'New', 'astrax-addons' ),
		] );

		$this->add_control( 'badge_style', [
			'label'   => esc_html__( 'Style', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'filled',
			'options' => [
				'filled'  => esc_html__( 'Filled', 'astrax-addons' ),
				'outline' => esc_html__( 'Outline', 'astrax-addons' ),
			],
		] );

		$this->add_control( 'badge_size', [
			'label'   => esc_html__( 'Size', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'md',
			'options' => [
				'sm' => esc_html__( 'Small', 'astrax-addons' ),
				'md' => esc_html__( 'Medium', 'astrax-addons' ),
				'lg' => esc_html__( 'Large', 'astrax-addons' ),
			],
		] );

		$this->add_control( 'badge_color', [
			'label'     => esc_html__( 'Background Color', 'astrax-addons' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .astrax-badge--filled' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				'{{WRAPPER}} .astrax-badge--outline' => 'border-color: {{VALUE}}; color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['badge_text'] ) ) {
			return;
		}

		$classes = [
			'astrax-badge',
			'astrax-badge--' . sanitize_html_class( $settings['badge_style'] ),
			'astrax-badge--' . sanitize_html_class( $settings['badge_size'] ),
		];

		$this->add_render_attribute( 'badge', 'class', $classes );
		?>
		<span <?php $this->print_render_attribute_string( 'badge' ); ?>>
			<?php echo esc_html( $settings['badge_text'] ); ?>
		</span>
		<?php
	}
}
