<?php
namespace AstraxAddons\Widgets\Typography;

use Elementor\Controls_Manager;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Animated Heading Widget — Typing/rotating/gradient text effects.
 */
class AnimatedHeading extends BaseWidget {

	public function get_name() {
		return 'astrax-animated-heading';
	}

	public function get_title() {
		return esc_html__( 'Animated Heading', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-animated-headline';
	}

	public function get_script_depends() {
		return [ 'astrax-animated-heading' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_heading',
			[
				'label' => esc_html__( 'Animated Heading', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'before_text', [
			'label'   => esc_html__( 'Before Text', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'We build', 'astrax-addons' ),
			'dynamic' => [ 'active' => true ],
			'label_block' => true,
		] );

		$this->add_control( 'animated_texts', [
			'label'       => esc_html__( 'Animated Words (one per line)', 'astrax-addons' ),
			'type'        => Controls_Manager::TEXTAREA,
			'default'     => "websites\napplications\nexperiences",
			'description' => esc_html__( 'Enter each word/phrase on a new line.', 'astrax-addons' ),
		] );

		$this->add_control( 'after_text', [
			'label'   => esc_html__( 'After Text', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '',
			'dynamic' => [ 'active' => true ],
		] );

		$this->add_control( 'animation_type', [
			'label'   => esc_html__( 'Animation', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'typing',
			'options' => [
				'typing'   => esc_html__( 'Typing', 'astrax-addons' ),
				'rotate'   => esc_html__( 'Rotate', 'astrax-addons' ),
				'fade'     => esc_html__( 'Fade', 'astrax-addons' ),
				'slide'    => esc_html__( 'Slide', 'astrax-addons' ),
			],
		] );

		$this->add_control( 'speed', [
			'label'   => esc_html__( 'Speed (ms)', 'astrax-addons' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 100,
			'min'     => 10,
			'max'     => 500,
		] );

		$this->add_control( 'pause', [
			'label'   => esc_html__( 'Pause (ms)', 'astrax-addons' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 2000,
			'min'     => 500,
			'max'     => 10000,
		] );

		$this->add_html_tag_control( 'html_tag', 'h2' );

		$this->end_controls_section();

		// Style
		$this->start_controls_section(
			'section_style_animated',
			[
				'label' => esc_html__( 'Animated Text', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control( 'animated_color', [
			'label'     => esc_html__( 'Animated Text Color', 'astrax-addons' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .astrax-animated-text' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$words = array_filter( array_map( 'trim', explode( "\n", $settings['animated_texts'] ) ) );
		if ( empty( $words ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', [
			'class'          => 'astrax-animated-heading',
			'data-animation' => esc_attr( $settings['animation_type'] ),
			'data-speed'     => esc_attr( $settings['speed'] ),
			'data-pause'     => esc_attr( $settings['pause'] ),
			'data-words'     => esc_attr( wp_json_encode( array_values( $words ) ) ),
		] );

		$tag = $settings['html_tag'];
		$safe_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' ];
		if ( ! in_array( strtolower( $tag ), $safe_tags, true ) ) {
			$tag = 'h2';
		}
		?>
		<<?php echo esc_html( $tag ); ?> <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( ! empty( $settings['before_text'] ) ) : ?>
				<span class="astrax-animated-before"><?php echo esc_html( $settings['before_text'] ); ?></span>
			<?php endif; ?>
			<span class="astrax-animated-text" aria-live="polite"><?php echo esc_html( $words[0] ); ?></span>
			<?php if ( ! empty( $settings['after_text'] ) ) : ?>
				<span class="astrax-animated-after"><?php echo esc_html( $settings['after_text'] ); ?></span>
			<?php endif; ?>
		</<?php echo esc_html( $tag ); ?>>
		<?php
	}
}
